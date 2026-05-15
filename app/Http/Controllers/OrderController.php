<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    // Список заказов пользователя
    public function index()
    {
        $orders = Auth::user()->orders()->orderByDesc('created_at')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Просмотр одного заказа
    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin() && !Auth::user()->isManager()) {
            abort(403);
        }
        $order->load('items.book');
        return view('orders.show', compact('order'));
    }

    // Оформление заказа из корзины
    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('book')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        // Подсчёт итоговой суммы
        $total = $cartItems->sum(fn($item) => $item->book->price * $item->quantity);

        // Создаём заказ
        $order = $user->orders()->create([
            'status' => 'Новый',
            'total_price' => $total,
        ]);

        // Переносим элементы корзины в позиции заказа
        foreach ($cartItems as $item) {
            $order->items()->create([
                'book_id' => $item->book_id,
                'quantity' => $item->quantity,
                'price' => $item->book->price, // фиксируем цену
            ]);
        }

        // Очищаем корзину
        $user->cartItems()->delete();

        return redirect()->route('orders.show', $order)->with('success', 'Заказ успешно оформлен');
    }
}
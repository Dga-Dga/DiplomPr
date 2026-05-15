<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('book')->get();
        $total = $cartItems->sum(fn($item) => $item->book->price * $item->quantity);
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request, Book $book)
    {
        $user = Auth::user();
        $cartItem = $user->cartItems()->where('book_id', $book->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $user->cartItems()->create([
                'book_id' => $book->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Книга добавлена в корзину');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        // проверка принадлежности пользователю
        if ($cartItem->user_id !== Auth::id()) abort(403);
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem->update(['quantity' => $request->quantity]);
        return redirect()->route('cart.index')->with('success', 'Количество обновлено');
    }

    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }
        CartItem::destroy($cartItem->id);
        return redirect()->route('cart.index')->with('success', 'Товар удалён из корзины');
    }
}

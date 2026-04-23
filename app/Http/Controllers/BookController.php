<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::latest()->get(); // все книги, новые сверху
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'title'  => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'price'  => 'required|numeric|min:0',
        'image'  => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // картинка обязательна
    ]);

    // Сохраняем картинку в storage/app/public/books
    $path = $request->file('image')->store('books', 'public');

    Book::create([
        'title'  => $validated['title'],
        'author' => $validated['author'],
        'price'  => $validated['price'],
        'image'  => $path, // в БД пишем относительный путь
    ]);

    return redirect()->route('books.index')->with('success', 'Книга добавлена!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
         return view('books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
         $validated = $request->validate([
        'title'  => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'price'  => 'required|numeric|min:0',
        'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // необязательно
    ]);

    $data = [
        'title'  => $validated['title'],
        'author' => $validated['author'],
        'price'  => $validated['price'],
    ];

    if ($request->hasFile('image')) {
        // Удаляем старую картинку
        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        // Сохраняем новую
        $data['image'] = $request->file('image')->store('books', 'public');
    }

    $book->update($data);

    return redirect()->route('books.index')->with('success', 'Книга обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Удаляем файл картинки
    if ($book->image) {
        Storage::disk('public')->delete($book->image);
    }
    $book->delete();

    return redirect()->route('books.index')->with('success', 'Книга удалена!');
    }
}

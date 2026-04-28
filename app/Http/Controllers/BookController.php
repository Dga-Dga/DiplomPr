<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



class BookController extends Controller
{
    private $genres = [
        'Художественная литература' => 'fa-book',
        'Детективы и триллеры'       => 'fa-mask',
        'Фантастика / Фэнтези'       => 'fa-rocket',
        'Любовные романы'            => 'fa-heart',
        'Бизнес и саморазвитие'      => 'fa-briefcase',
        'Научно-популярное'          => 'fa-flask',
        'Детские книги'              => 'fa-child',
        'Кулинария и хобби'          => 'fa-utensils',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Поиск по названию
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        // Фильтр по жанру
        if ($request->filled('genre')) {
            $query->where('genre', $request->input('genre'));
        }

        // Новинки недели (если передан параметр new)
        if ($request->has('new')) {
            $query->where('created_at', '>=', now()->subWeek());
        }

        $books = $query->latest()->get();

        // Счётчики книг по жанрам (всегда все, чтобы sidebar показывал актуальные цифры)
        $genreCounts = Book::select('genre', DB::raw('count(*) as count'))
        ->groupBy('genre')
        ->pluck('count', 'genre');

        $genres = $this->genres;

        $totalBooksCount = Book::query()->count('*');

        return view('books.index', compact('books', 'genres', 'genreCounts', 'totalBooksCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = $this->genres;
        return view('books.create', compact('genres'));
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
            'genre'  => 'required|string|max:255',
            'image'  => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);



        $path = $request->file('image')->store('books', 'public');

        Book::create([
            'title'  => $validated['title'],
            'author' => $validated['author'],
            'price'  => $validated['price'],
            'genre'  => $validated['genre'],
            'image'  => $path,
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
        $genres = $this->genres;
        return view('books.edit', compact('book', 'genres'));
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
            'genre' => 'required|string|max:255',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // необязательно
        ]);

        $data = [
            'title'  => $validated['title'],
            'author' => $validated['author'],
            'price'  => $validated['price'],
            'genre'  => $validated['genre'],  
        ];

        if ($request->hasFile('image')) {

            if ($book->image) {
                Storage::disk('public')->delete($book->image);
            }

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

        if ($book->image) {
            Storage::disk('public')->delete($book->image);
        }
        Book::destroy($book->id);

        return redirect()->route('books.index')->with('success', 'Книга удалена!');
    }
}

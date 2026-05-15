<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    // Показать список избранного
    public function index(Request $request)
    {
        $favorites = Auth::user()
            ->favorites()
            ->latest('favorites.created_at')
            ->paginate(15);

        return view('favorites.index', compact('favorites'));
    }

    // Добавить в избранное
    public function store(Request $request, Book $book): JsonResponse
{
    $user = Auth::user();
    $user->favorites()->syncWithoutDetaching([$book->id]);
    return response()->json(['favorited' => true]);
}

public function destroy(Request $request, Book $book): JsonResponse
{
    Auth::user()->favorites()->detach($book->id);
    return response()->json(['favorited' => false]);
}
}
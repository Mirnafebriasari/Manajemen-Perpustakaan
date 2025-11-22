<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class BookController extends Controller
{
public function index(Request $request)
{
    $query = Book::query();

    // Search judul / penulis
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('title', 'like', '%'.$request->search.'%')
              ->orWhere('author', 'like', '%'.$request->search.'%');
        });
    }

    // Filter kategori
    if ($request->category) {
        $query->where('category', $request->category);
    }

    // Sorting berdasarkan kolom yang diijinkan
    $allowedSorts = ['title', 'author', 'publication_year', 'rating', 'created_at'];
    $sort = $request->sort;
    if ($sort && in_array($sort, $allowedSorts)) {
        $query->orderBy($sort, 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $books = $query->paginate(10);

    // Untuk filter kategori dropdown
    $categories = Book::select('category')->distinct()->pluck('category');

    return view('books.index', compact('books', 'categories'));
}

    // Form create buku
    public function create()
    {
        return view('books.create');
    }

    // Simpan buku baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|digits:4|integer',
            'category' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'max_loan_days' => 'required|integer|min:1',
            'fine_per_day' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    // Form edit buku
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    // Update buku
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'publication_year' => 'required|digits:4|integer',
            'category' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'max_loan_days' => 'required|integer|min:1',
            'fine_per_day' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Buku berhasil diupdate');
    }

public function show($id)
{
    $book = Book::findOrFail($id);

    // Ambil review terkait buku
    $reviews = $book->reviews()->with('user')->latest()->get();

    return view('books.show', compact('book', 'reviews'));
}


    // Hapus buku
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus');
    }
}

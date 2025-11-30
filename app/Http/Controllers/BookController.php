<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('author', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $allowedSorts = ['title', 'author', 'publication_year', 'rating', 'created_at'];
        $sort = $request->sort;
        if ($sort && in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $books = $query->paginate(10);
        $categories = Book::select('category')->distinct()->pluck('category');
        return view('books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $formAction = route('admin.books.store');
        } elseif ($user->hasRole('pegawai')) {
            $formAction = route('pegawai.books.store');
        } else {
            abort(403);
        }

        return view('books.create', compact('formAction'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'author'           => 'required|string|max:255',
            'publisher'        => 'required|string|max:255',
            'publication_year' => 'required|digits:4|integer',
            'category'         => 'required|string|max:255',
            'stock'            => 'required|integer|min:0',
            'max_loan_days'    => 'required|integer|min:1',
            'fine_per_day'     => 'required|numeric|min:0',
            'description'      => 'nullable|string',
            'photo'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/book_photos', $filename);
            $data['photo'] = $filename;
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'author'           => 'required|string|max:255',
            'publisher'        => 'required|string|max:255',
            'publication_year' => 'required|digits:4|integer',
            'category'         => 'required|string|max:255',
            'stock'            => 'required|integer|min:0',
            'max_loan_days'    => 'required|integer|min:1',
            'fine_per_day'     => 'required|numeric|min:0',
            'description'      => 'nullable|string',
            'photo'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $oldStock = $book->stock;

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/book_photos', $filename);
            $data['photo'] = $filename;

            if ($book->photo) {
                Storage::delete('public/book_photos/' . $book->photo);
            }
        }

        $book->update($data);

        \Log::info('Update Book', [
            'book_id'  => $book->id,
            'old_stock'=> $oldStock,
            'new_stock'=> $book->stock,
            'increase' => $book->stock - $oldStock,
        ]);

        if ($book->stock > $oldStock) {
            $stockIncrease = $book->stock - $oldStock;

            \Log::info('Processing reservations', ['count' => $stockIncrease]);

            for ($i = 0; $i < $stockIncrease; $i++) {
                $book->refresh();

                if ($book->stock > 0) {
                    \Log::info('Calling processReservation', ['iteration' => $i + 1, 'current_stock' => $book->stock]);

                    $result = app(\App\Http\Controllers\ReservationController::class)
                        ->processReservation($book);

                    \Log::info('processReservation result', ['result' => $result ? 'processed' : 'no reservation']);
                } else {
                    \Log::info('Stock depleted, stopping');
                    break;
                }
            }
        }

        return redirect()->route('books.index')->with('success', 'Buku berhasil diupdate dan reservasi diproses');
    }

    public function destroy(Book $book)
{
    if ($book->photo) {
        \Storage::delete('public/book_photos/' . $book->photo);
    }

    $book->delete();

    return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus');
}


    public function show($id)
    {
        $book = Book::findOrFail($id);

        $stokSaatIni = $book->stock;

        $reviews = $book->reviews()->with('user')->latest()->get();

        return view('books.show', compact('book', 'reviews', 'stokSaatIni'));
    }
}

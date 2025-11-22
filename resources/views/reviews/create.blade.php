@extends('layouts.app')

@section('content')
<h1>Beri Ulasan untuk Buku: {{ $book->title }}</h1>

<form action="{{ route('loans.review.store', $loan->id) }}" method="POST">
    @csrf
    <input type="hidden" name="book_id" value="{{ $book->id }}">

    <label for="rating">Rating (1-5):</label>
    <select name="rating" id="rating" required>
        @for($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
        @endfor
    </select>

    <label for="comment">Komentar / Ulasan:</label>
    <textarea name="comment" id="comment" rows="4"></textarea>

    <button type="submit">Kirim Ulasan</button>
</form>
@endsection

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('authors')->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'image|nullable',
            'authors' => 'required|array',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $book = Book::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // Attach authors to the book
        $book->authors()->attach($request->authors);

        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $authors = Author::all();
        $selectedAuthors = $book->authors->pluck('id')->toArray();

        return view('books.edit', compact('book', 'authors', 'selectedAuthors'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'image|nullable',
            'authors' => 'required|array',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('book_images', 'public');
            $book->image = $imagePath;
        }

        $book->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Update the authors
        $book->authors()->sync($request->authors);

        return redirect()->route('books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->authors()->detach();
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}

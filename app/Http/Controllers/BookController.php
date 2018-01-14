<?php

namespace App\Http\Controllers;


use App\Models\Book;
use Illuminate\Http\Request;

class BookController
{

    /**
     * Get all books.
     */
    public function all()
    {
        return Book::paginate(15);
    }

    /**
     * Get a specific book.
     *
     * @param $id
     */
    public function get($id)
    {
        return Book::find($id);
    }

    /**
     * Create new book.
     */
    public function create(Request $request)
    {

        $book = new Book(
          [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'isbn' => $request->input('isbn'),
          ]
        );
        $book->save();

        return response($book, 201);
    }

    /**
     * Delete a book.
     *
     * @param $id
     */
    public function delete($id)
    {
        $book = Book::find($id);

        $book->delete();
        return response('deleted!', 202);
    }
}
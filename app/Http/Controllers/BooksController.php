<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Exception;

class BooksController extends Controller
{
    //
    function addBook(Request $req)
    {
        $book = new Book();
        $book->title = $req->input('title');
        $book->author = $req->input('author');
        $book->genre_id = $req->input('genre_id');
        $book->description = $req->input('description');
        $book->numberInStock = $req->input('numberInStock');
        $book->image = $req->file('image')->store('book_pictures');
        $book->save();
        return $book;
    }

    function list()
    {
        return Book::all();
    }

    function saveBook($id, Request $req)
    {
        $book = Book::find($id);
        $book->title = $req->input('title');
        $book->author = $req->input('author');
        $book->genreId = $req->input('genreId');
        $book->description = $req->input('description');
        $book->numberInStock = $req->input('numberInStock');
        if ($req->file('image')) {
            $book->image = $req->file('image')->store('book_pictures');
        }
        $book->save();
        return $book;
    }

    function delete($id)
    {
        $result = Book::where('id', $id)->delete();
        if ($result) {
            return ['result' => 'Book has been deleted'];
        } else {
            return ['result' => 'Book not found'];
        }
    }

    function getBook($id)
    {
        $result = Book::find($id);
        if ($result) {
            return $result;
        } else {
            return ['result' => 'Book not found'];
        }
    }
}

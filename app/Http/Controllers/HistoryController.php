<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReaderHistory;
use App\Models\Book;
use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Date;
use Carbon\Carbon;

class HistoryController extends Controller
{
    //
    protected $BooksController;

    public function __construct(BooksController $booksController)
    {
        $this->BooksController = $booksController;
    }

    function getReaderHistory()
    {
        return ReaderHistory::all();
        // $result = ReaderHistory::where('userId', $userId)->first();
        // if ($result) {
        //     return $result;
        // } else {
        //     return 'No books read so far!';
        // }
    }

    function addReaderHistory($userId, $bookId)
    {
        // $bookId = $req->input('bookId');
        $this->BooksController->decrementStock($bookId);

        $history = ReaderHistory::where('userId', $userId)->where('bookId', $bookId)->first();

        if ($history) {
            $history->currently_Reading = true;
            $history->issuedAt = Carbon::now();
            $history->save();
            return $history;
        } else {
            $newHistory = new ReaderHistory();
            $newHistory->userId = $userId;
            $newHistory->bookId = $bookId;
            $newHistory->currently_Reading = true;
            $newHistory->issuedAt = Carbon::now();
            $newHistory->save();
            return $newHistory;
        }
    }

    function isReading($userId)
    {
        $result = ReaderHistory::where('userId', $userId)
            ->where('currently_Reading', '=', 1)->first();
        if ($result)
            return 1;
        else
            return 0;
    }

    function issueBook($bookid, Request $req)
    {
        $userId = $req->input('userId');
        if ($this->isReading($userId)) {
            return 'Return current book first';
        } else if ($this->BooksController->getNumberInStock($bookid)) {
            return $this->addReaderHistory($userId, $bookid);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReaderHistory;


class HistoryController extends Controller
{
    //
    function getReaderHistory()
    {
        return ReaderHistory::all();
    }
}

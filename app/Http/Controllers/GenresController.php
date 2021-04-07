<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;


class GenresController extends Controller
{
    //
    function getGenres()
    {
        return Genre::all();
    }
}

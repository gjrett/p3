<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class DateController extends Controller
{

    /**
     * GET /date
     */
    public function index()
    {
        return 'Here is the form for the date input...';
    }

    /**
     * GET /dateInfo/{date}
     */
    public function show($date)
    {
        return 'Results for the date: ' . $date;
    }
}
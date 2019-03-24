<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class BirthdayController extends Controller
{

    /**
     * GET /date
     */
    public function index()
    {
        return view('birthday.inputForm');
    }

    /**
     * GET /dateInfo/{date}
     */
    public function show()
    {
        return view('birthday.show');
    }

}
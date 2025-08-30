<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutMeController extends Controller
{
    public function index()
    {
        return view('user.about-me');
    }

    public function msb()
    {
        return view('user.msb');
    }
} 
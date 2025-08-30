<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Symbol;
class BitgetEarningController extends Controller
{
    public function index()
    {
        # Get all symbols
        $symbols = Symbol::where('status', 1)->get();
        
        return view('bitget.earning', compact('symbols'));
    }
} 
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Symbol;

class CopyTradingController extends Controller
{
    public function overview()
    {
        $symbols = Symbol::where('status', 1)->get();
        return view('bitget.copy-trading.overview', compact('symbols'));
    }
} 
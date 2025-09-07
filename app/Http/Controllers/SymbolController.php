<?php

namespace App\Http\Controllers;

use App\Models\Symbol;
use Illuminate\Http\Request;

class SymbolController extends Controller
{
    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);
        $category = $request->get('category', '');

        $query = Symbol::active()->orderBy('id', 'desc');
        
        if ($category) {
            $query->where('category', $category);
        }

        $symbols = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        return response()->json([
            'symbols' => $symbols
        ]);
    }

    public function getByCategory(Request $request)
    {
        $category = $request->get('category', 'forex');
        $symbols = Symbol::active()->byCategory($category)->get();
        
        return response()->json([
            'symbols' => $symbols
        ]);
    }
} 
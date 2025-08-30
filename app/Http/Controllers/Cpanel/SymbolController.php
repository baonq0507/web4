<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Symbol;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class SymbolController extends Controller
{
    public function symbols()
    {
        $symbols = Symbol::all();
        return view('cpanel.symbols', compact('symbols'));
    }

    public function storeSymbol(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:symbols,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'symbol' => 'required|string|max:255|unique:symbols,symbol',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => __('index.name_required'),
            'name.string' => __('index.name_string'),
            'name.max' => __('index.name_max', ['max' => 255]),
            'image.required' => __('index.image_required'),
            'image.image' => __('index.image_image'),
            'image.mimes' => __('index.image_mimes'),
            'image.max' => __('index.image_max', ['max' => 2048]),
            'symbol.required' => __('index.symbol_required'),
            'symbol.string' => __('index.symbol_string'),
            'symbol.max' => __('index.symbol_max', ['max' => 255]),
            'symbol.unique' => __('index.symbol_unique'),
            'status.required' => __('index.status_required'),
            'status.boolean' => __('index.status_boolean'),
            'profit_win.required' => __('index.profit_win_required'),
            'profit_win.integer' => __('index.profit_win_integer'),
            'profit_win.min' => __('index.profit_win_min', ['min' => 0]),
            'profit_win.max' => __('index.profit_win_max', ['max' => 100]),
            'profit_lose.required' => __('index.profit_lose_required'),
            'profit_lose.integer' => __('index.profit_lose_integer'),
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/symbols'), $imageName);
        }
        $symbol = new Symbol();
        $symbol->name = $request->name;
        $symbol->image = $imageName;
        $symbol->symbol = $request->symbol;
        $symbol->status = $request->status;
        $symbol->save();

        return response()->json(['message' => __('index.symbol_created_successfully')]);
    }

    public function showSymbol($symbol)
    {
        $symbol = Symbol::find($symbol);
        return response()->json($symbol);
    }

    public function updateSymbol(Request $request, $symbol)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:symbols,name,' . $symbol,
            'symbol' => 'required|string|max:255|unique:symbols,symbol,' . $symbol,
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => __('index.name_required'),
            'name.string' => __('index.name_string'),
            'name.max' => __('index.name_max', ['max' => 255]),
            'symbol.required' => __('index.symbol_required'),
            'symbol.string' => __('index.symbol_string'),
            'symbol.max' => __('index.symbol_max', ['max' => 255]),
            'symbol.unique' => __('index.symbol_unique'),
            'status.required' => __('index.status_required'),
            'status.in' => __('index.status_in'),
            'profit_win.required' => __('index.profit_win_required'),
            'profit_win.integer' => __('index.profit_win_integer'),
            'profit_win.min' => __('index.profit_win_min', ['min' => 0]),
            'profit_win.max' => __('index.profit_win_max', ['max' => 100]),
            'profit_lose.required' => __('index.profit_lose_required'),
            'profit_lose.integer' => __('index.profit_lose_integer'),
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $symbol = Symbol::find($symbol);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/symbols'), $imageName);
            $symbol->image = $imageName;
        }
        $symbol->name = $request->name;
        $symbol->symbol = $request->symbol;
        $symbol->status = $request->status;
        $symbol->save();

        return response()->json(['message' => __('index.symbol_updated_successfully')]);
    }

    public function destroySymbol($symbol)
    {
        $symbol = Symbol::find($symbol);
        $symbol->delete();

        return response()->json(['message' => __('index.symbol_deleted_successfully')]);
    }
}

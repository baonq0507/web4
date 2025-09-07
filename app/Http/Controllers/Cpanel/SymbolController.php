<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Symbol;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class SymbolController extends Controller
{
    public function symbols(Request $request)
    {
        $query = Symbol::query();
        
        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $symbols = $query->orderBy('category')->orderBy('name')->get();
        $categories = ['crypto', 'usa', 'forex'];
        
        return view('cpanel.symbols', compact('symbols', 'categories'));
    }

    public function storeSymbol(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:symbols,name',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'symbol' => 'required|string|max:255|unique:symbols,symbol',
            'status' => 'required|in:active,inactive',
            'category' => 'required|in:crypto,usa,forex',
            'description' => 'nullable|string|max:500',
            'base_currency' => 'nullable|string|max:10',
            'quote_currency' => 'nullable|string|max:10',
            'tick_size' => 'nullable|numeric|min:0',
            'lot_size' => 'nullable|numeric|min:0',
            'is_margin_trading' => 'nullable|boolean',
            'max_leverage' => 'nullable|integer|min:1|max:1000',
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
        $symbol->category = $request->category;
        $symbol->description = $request->description;
        $symbol->base_currency = $request->base_currency;
        $symbol->quote_currency = $request->quote_currency;
        $symbol->tick_size = $request->tick_size ?? 0.00001;
        $symbol->lot_size = $request->lot_size ?? 1.00;
        $symbol->is_margin_trading = $request->has('is_margin_trading') ? true : false;
        $symbol->max_leverage = $request->max_leverage ?? 1;
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
            'category' => 'required|in:crypto,usa,forex',
            'description' => 'nullable|string|max:500',
            'base_currency' => 'nullable|string|max:10',
            'quote_currency' => 'nullable|string|max:10',
            'tick_size' => 'nullable|numeric|min:0',
            'lot_size' => 'nullable|numeric|min:0',
            'is_margin_trading' => 'nullable|boolean',
            'max_leverage' => 'nullable|integer|min:1|max:1000',
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
        $symbol->category = $request->category;
        $symbol->description = $request->description;
        $symbol->base_currency = $request->base_currency;
        $symbol->quote_currency = $request->quote_currency;
        $symbol->tick_size = $request->tick_size ?? 0.00001;
        $symbol->lot_size = $request->lot_size ?? 1.00;
        $symbol->is_margin_trading = $request->has('is_margin_trading') ? true : false;
        $symbol->max_leverage = $request->max_leverage ?? 1;
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

<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\Project;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::with(['user', 'project'])->latest()->paginate(10);
        return view('cpanel.investments.index', compact('investments'));
    }

    public function show(Investment $investment)
    {
        $investment->load(['user', 'project']);
        return view('cpanel.investments.show', compact('investment'));
    }

    public function update(Request $request, Investment $investment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $investment->update($validated);

        return redirect()->route('cpanel.investments.index')
            ->with('success', 'Investment status updated successfully');
    }

    public function destroy(Investment $investment)
    {
        $investment->delete();
        return redirect()->route('cpanel.investments.index')
            ->with('success', 'Investment deleted successfully');
    }
} 
<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Models\TimeSession;
use Illuminate\Http\Request;

class TimeSessionController extends Controller
{
    public function index()
    {
        $timeSessions = TimeSession::latest()->paginate(10);
        return view('admin.time-sessions.index', compact('timeSessions'));
    }

    public function create()
    {
        return view('admin.time-sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'time' => 'required|numeric',
            'unit' => 'required|string',
            'win_rate' => 'required|numeric|min:0|max:100',
            'lose_rate' => 'required|numeric|min:0|max:100',
            'status' => 'required|boolean',
        ]);

        TimeSession::create($request->all());

        return redirect()->route('cpanel.time-sessions.index')
            ->with('success', 'Time session created successfully.');
    }

    public function edit(TimeSession $timeSession)
    {
        return view('admin.time-sessions.edit', compact('timeSession'));
    }

    public function update(Request $request, TimeSession $timeSession)
    {
        $request->validate([
            'time' => 'required|numeric',
            'unit' => 'required|string',
            'win_rate' => 'required|numeric|min:0|max:100',
            'lose_rate' => 'required|numeric|min:0|max:100',
            'status' => 'required|boolean',
        ]);

        $timeSession->update($request->all());

        return redirect()->route('cpanel.time-sessions.index')
            ->with('success', 'Time session updated successfully');
    }

    public function destroy(TimeSession $timeSession)
    {
        $timeSession->delete();

        return redirect()->route('cpanel.time-sessions.index')
            ->with('success', 'Time session deleted successfully');
    }
} 
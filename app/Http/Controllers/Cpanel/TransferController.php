<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Symbol;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('type', 'transfer')
            ->with(['user', 'symbol'])
            ->orderBy('created_at', 'desc');

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by currency
        if ($request->filled('currency')) {
            if ($request->currency === 'USDT') {
                $query->whereNull('symbol_id');
            } else {
                $symbol = Symbol::where('symbol', $request->currency)->first();
                if ($symbol) {
                    $query->where('symbol_id', $symbol->id);
                }
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by amount range
        if ($request->filled('amount_from')) {
            $query->where('amount', '>=', $request->amount_from);
        }

        if ($request->filled('amount_to')) {
            $query->where('amount', '<=', $request->amount_to);
        }

        $transfers = $query->paginate(20);

        // Get filter data
        $users = User::select('id', 'name', 'username', 'email')->get();
        $currencies = Symbol::select('symbol')->distinct()->pluck('symbol')->toArray();
        $currencies[] = 'USDT';

        // Get statistics
        $stats = $this->getTransferStats($request);

        return view('cpanel.transfers.index', compact('transfers', 'users', 'currencies', 'stats'));
    }

    public function show($id)
    {
        $transfer = Transaction::where('type', 'transfer')
            ->where('id', $id)
            ->with(['user', 'symbol'])
            ->firstOrFail();

        return view('cpanel.transfers.show', compact('transfer'));
    }

    public function export(Request $request)
    {
        $query = Transaction::where('type', 'transfer')
            ->with(['user', 'symbol']);

        // Apply same filters as index
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('currency')) {
            if ($request->currency === 'USDT') {
                $query->whereNull('symbol_id');
            } else {
                $symbol = Symbol::where('symbol', $request->currency)->first();
                if ($symbol) {
                    $query->where('symbol_id', $symbol->id);
                }
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transfers = $query->orderBy('created_at', 'desc')->get();

        $filename = 'transfers_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($transfers) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, [
                'ID',
                'User',
                'Email',
                'Currency',
                'Amount',
                'From Account',
                'To Account',
                'Status',
                'Description',
                'Created At'
            ]);

            // CSV Data
            foreach ($transfers as $transfer) {
                fputcsv($file, [
                    $transfer->id,
                    $transfer->user->name ?? $transfer->user->username,
                    $transfer->user->email,
                    $transfer->symbol ? $transfer->symbol->symbol : 'USDT',
                    $transfer->amount,
                    $this->getAccountName($transfer->note),
                    $this->getAccountName($transfer->note, 'to'),
                    $transfer->status,
                    $transfer->description,
                    $transfer->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getTransferStats($request)
    {
        $query = Transaction::where('type', 'transfer');

        // Apply same filters
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('currency')) {
            if ($request->currency === 'USDT') {
                $query->whereNull('symbol_id');
            } else {
                $symbol = Symbol::where('symbol', $request->currency)->first();
                if ($symbol) {
                    $query->where('symbol_id', $symbol->id);
                }
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $stats = $query->selectRaw('
            COUNT(*) as total_transfers,
            SUM(amount) as total_amount,
            AVG(amount) as avg_amount,
            COUNT(DISTINCT user_id) as unique_users
        ')->first();

        return $stats;
    }

    private function getAccountName($note, $type = 'from')
    {
        if (!$note) return 'N/A';
        
        $parts = explode(' ', $note);
        if (count($parts) >= 3) {
            if ($type === 'from') {
                return $parts[1]; // "Transfer from spot to wallet" -> "spot"
            } else {
                return $parts[3]; // "Transfer from spot to wallet" -> "wallet"
            }
        }
        
        return 'N/A';
    }
}

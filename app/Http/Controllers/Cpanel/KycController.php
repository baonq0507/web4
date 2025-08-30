<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserKyc;
use Pusher\Pusher;
class KycController extends Controller
{
    public function index()
    {
        $kycs = UserKyc::with('user')->orderBy('created_at', 'desc')->get();
        return view('cpanel.kycs.index', compact('kycs'));
    }

    public function update(Request $request, UserKyc $kyc)
    {
        $kyc->update($request->all());
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ]);
        if ($request->status == 'approved') {
            $pusher->trigger('kyc-channel', 'kyc-approved', ['kyc' => $kyc]);
        }elseif($request->status == 'rejected'){
            $pusher->trigger('kyc-channel', 'kyc-rejected', ['kyc' => $kyc]);
        }elseif($request->status == 'sent_again'){
            $pusher->trigger('kyc-channel', 'kyc-sent-again', ['kyc' => $kyc]);
        }
        return response()->json(['message' => __('index.kyc_updated_successfully')]);
    }

    public function destroy(UserKyc $kyc)
    {
        $kyc->delete();
        return response()->json(['message' => __('index.kyc_deleted_successfully')]);
    }
}

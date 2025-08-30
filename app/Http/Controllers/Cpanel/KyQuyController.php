<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KyQuy;
use App\Models\KyQuyUser;
use Illuminate\Support\Facades\Storage;
use Pusher\Pusher;

class KyQuyController extends Controller
{
    public function index()
    {
        $kyQuies = KyQuy::orderBy('created_at', 'desc')->paginate(10);
        return view('cpanel.ky-quies.index', compact('kyQuies'));
    }

    public function create()
    {
        return view('cpanel.ky-quies.create');
    }

    public function store(Request $request)
    {

        $data = $request->all();
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }
        KyQuy::create($data);
        
        return redirect()->route('cpanel.ky-quies.index')->with('success', __('index.ky_quy_create'));
    }

    public function edit($id)
    {
        $kyQuy = KyQuy::find($id);
        return view('cpanel.ky-quies.edit', compact('kyQuy'));
    }

    public function update(Request $request, $id)
    {
        $kyQuy = KyQuy::find($id);
        $data = $request->all();
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }
        $kyQuy->update($data);
        return redirect()->route('cpanel.ky-quies.index')->with('success', __('index.ky_quy_update'));
    }

    public function destroy($id)
    {
        $kyQuy = KyQuy::find($id);
        $kyQuy->delete();
        return redirect()->route('cpanel.ky-quies.index')->with('success', __('index.ky_quy_destroy'));
    }

    public function kyQuyUsers()
    {
        $kyQuyUsers = KyQuyUser::orderBy('created_at', 'desc')->paginate(10);
        return view('cpanel.ky-quy-users.index', compact('kyQuyUsers'));
    }

    public function kyQuyUserEdit($id)
    {
        $kyQuyUser = KyQuyUser::find($id);
        return view('cpanel.ky-quy-users.edit', compact('kyQuyUser'));
    }

    public function kyQuyUserUpdate(Request $request, $id)
    {
        $kyQuyUser = KyQuyUser::find($id);
        $kyQuyUser->update($request->all());
        return redirect()->route('cpanel.ky-quy-users.index')->with('success', __('index.ky_quy_user_update'));
    }

    public function kyQuyUserDestroy($id)
    {
        $kyQuyUser = KyQuyUser::find($id);
        $kyQuyUser->delete();
        return redirect()->route('cpanel.ky-quy-users.index')->with('success', __('index.ky_quy_user_destroy'));
    }

    public function kyQuyUserApprove($id)
    {
        $kyQuyUser = KyQuyUser::find($id);
        $kyQuyUser->status = 'approve';
        $kyQuyUser->approve_date = now();
        $kyQuyUser->save();

        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);

        $pusher->trigger('ky-quy-approve-channel', 'ky-quy-approve-event_'.$kyQuyUser->user_id, [
            'kyQuyUser' => $kyQuyUser,
            'message' => __('index.kyc_approve_success', ['name' => $kyQuyUser->user->name])
        ]);
        
        return response()->json(['success' => __('index.approve_ky_quy_user_success')]);
    }

    public function kyQuyUserReject($id)
    {
        $kyQuyUser = KyQuyUser::find($id);
        $kyQuyUser->status = 'cancel';
        $kyQuyUser->cancel_date = now();
        $kyQuyUser->user->balance += $kyQuyUser->balance;
        $kyQuyUser->user->save();
        $kyQuyUser->save();


        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);

        $pusher->trigger('ky-quy-reject-channel', 'ky-quy-reject-event_'.$kyQuyUser->user_id, [
            'kyQuyUser' => $kyQuyUser,
            'message' => __('index.kyc_reject_success', ['name' => $kyQuyUser->user->name])
        ]);

        return response()->json(['success' => __('index.reject_ky_quy_user_success')]);
    }

    public function kyQuyUserStop($id)
    {
        $kyQuyUser = KyQuyUser::find($id);
        $kyQuyUser->status = 'stop';
        $kyQuyUser->stop_date = now();
        $kyQuyUser->save();
        return response()->json(['success' => __('index.stop_ky_quy_user_success')]);
    }

    public function kyQuyUserFinish($id)
    {
        $kyQuyUser = KyQuyUser::find($id);
        $kyQuyUser->status = 'finish';
        $kyQuyUser->finish_date = now();
        $kyQuyUser->save();

        // cộng tiền cho user
        $kyQuyUser->user->balance += $kyQuyUser->balance + $kyQuyUser->profit;
        $kyQuyUser->user->save();

        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ]);

        $pusher->trigger('ky-quy-finish-channel', 'ky-quy-finish-event_'.$kyQuyUser->user_id, [
            'kyQuyUser' => $kyQuyUser,
            'message' => __('index.kyc_finish_success', ['name' => $kyQuyUser->user->name])
        ]);
        return response()->json(['success' => __('index.finish_ky_quy_user_success')]);
    }
}

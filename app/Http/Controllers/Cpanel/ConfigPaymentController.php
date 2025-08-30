<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConfigPayment;
use Illuminate\Support\Facades\Validator;
class ConfigPaymentController extends Controller
{
    public function index()
    {
        $banks = ConfigPayment::orderBy('created_at', 'desc')->get();
        return view('cpanel.config-payment', compact('banks'));
    }

    public function show(Request $request, $id)
    {
        $bank = ConfigPayment::find($id);
        if(!$bank){
            return response()->json(['message' => __('index.not_found')], 404);
        }
        return response()->json($bank);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:255',
            'bank_number' => 'required|string|max:255',
            'bank_owner' => 'required|string|max:255',
            'status' => 'required|in:show,hide',
        ], [
            'bank_name.required' => __('index.bank_name_required'),
            'bank_number.required' => __('index.bank_number_required'),
            'bank_owner.required' => __('index.bank_owner_required'),
            'status.required' => __('index.status_required'),
            'status.in' => __('index.status_in'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        ConfigPayment::create($request->all());
        return response()->json(['message' => __('index.success')]);
    }

    public function update(Request $request, $id)
    {
        $bank = ConfigPayment::find($id);
        if(!$bank){
            return response()->json(['message' => __('index.not_found')], 404);
        }

        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:255',
            'bank_number' => 'required|string|max:255',
            'bank_owner' => 'required|string|max:255',
            'status' => 'required|in:show,hide',
        ], [
            'bank_name.required' => __('index.bank_name_required'),
            'bank_number.required' => __('index.bank_number_required'),
            'bank_owner.required' => __('index.bank_owner_required'),
            'status.required' => __('index.status_required'),
            'status.in' => __('index.status_in'),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $bank->update($request->all());
        return response()->json(['message' => __('index.success')]);
    }

    public function destroy(Request $request, $id)
    {
        $bank = ConfigPayment::find($id);
        if(!$bank){
            return response()->json(['message' => __('index.not_found')], 404);
        }

        $bank->delete();
        return response()->json(['message' => __('index.success')]);
    }
}
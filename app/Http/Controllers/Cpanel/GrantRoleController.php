<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class GrantRoleController extends Controller
{
    public function grantRole(Request $request)
    {
        $roles = Role::orderBy('id', 'desc')->get();
        $permissions = Permission::orderBy('id', 'desc')->get();
        return view('cpanel.grant_role', compact('roles', 'permissions'));
    }

    public function postGrantRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => __('index.name_required'),
            'name.string' => __('index.name_string'),
            'name.max' => __('index.name_max' , ['max' => 255]),
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }
        if (Role::where('name', $request->name)->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => __('index.grant_role_exists'),
            ], 400);
        }
        Role::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => __('index.grant_role_success'),
        ], 200);
    }

    public function destroyGrantRole(Request $request, $role)
    {
        $role = Role::find($role);
        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => __('index.delete_not_found'),
            ], 404);
        }
        $role->delete();
        return response()->json([
            'status' => 'success',
            'message' => __('index.delete_success'),
        ], 200);
    }

    public function showGrantRole(Request $request, $role)
    {
        $role = Role::with('permissions')->find($role);
        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => __('index.delete_not_found'),
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'role' => $role,
        ], 200);
    }

    public function updateGrantRole(Request $request, $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => __('index.name_required'),
            'name.string' => __('index.name_string'),
            'name.max' => __('index.name_max' , ['max' => 255]),
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }
        $role = Role::find($role);
        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => __('index.delete_not_found'),
            ], 404);
        }
        $role->update([
            'name' => $request->name,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => __('index.update_success'),
        ], 200);
    }

    public function assignPermission(Request $request, $role)
    {
        $role = Role::find($role);
        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => __('index.delete_not_found'),
            ], 404);
        }
        $role->permissions()->sync($request->permissions);
        return response()->json([
            'status' => 'success',
            'message' => __('index.assign_permission_success'),
        ], 200);
    }
}

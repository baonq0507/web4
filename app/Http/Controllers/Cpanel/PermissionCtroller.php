<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Yajra\Datatables\Datatables;
class PermissionCtroller extends Controller
{

    public function getData()
    {

        $role = Role::all();
        $permission = Permission::all();
        return view('cpanel.permissions.index', compact('role', 'permission', 'user'));
    }

    public function store(Request $request)
    {
        $permission = Permission::create($request->all());
    }
}

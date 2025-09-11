<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VipLevel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VipController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $vipLevels = VipLevel::orderBy('sort_order')->get();
        return view('admin.vip.index', compact('vipLevels'));
    }

    public function create()
    {
        return view('admin.vip.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:10|unique:vip_levels',
            'display_name' => 'required|string|max:255',
            'min_deposit' => 'required|numeric|min:0',
            'max_deposit' => 'nullable|numeric|gt:min_deposit',
            'benefits' => 'nullable|array',
            'color' => 'required|string|max:7',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        VipLevel::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'min_deposit' => $request->min_deposit,
            'max_deposit' => $request->max_deposit,
            'benefits' => $request->benefits ? json_encode($request->benefits) : null,
            'color' => $request->color,
            'icon' => $request->icon,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.vip.index')->with('success', 'VIP Level đã được tạo thành công!');
    }

    public function show(VipLevel $vipLevel)
    {
        $users = $vipLevel->users()->paginate(20);
        return view('admin.vip.show', compact('vipLevel', 'users'));
    }

    public function edit(VipLevel $vipLevel)
    {
        return view('admin.vip.edit', compact('vipLevel'));
    }

    public function update(Request $request, VipLevel $vipLevel)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:10|unique:vip_levels,name,' . $vipLevel->id,
            'display_name' => 'required|string|max:255',
            'min_deposit' => 'required|numeric|min:0',
            'max_deposit' => 'nullable|numeric|gt:min_deposit',
            'benefits' => 'nullable|array',
            'color' => 'required|string|max:7',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $vipLevel->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'min_deposit' => $request->min_deposit,
            'max_deposit' => $request->max_deposit,
            'benefits' => $request->benefits ? json_encode($request->benefits) : null,
            'color' => $request->color,
            'icon' => $request->icon,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order,
        ]);

        return redirect()->route('admin.vip.index')->with('success', 'VIP Level đã được cập nhật thành công!');
    }

    public function destroy(VipLevel $vipLevel)
    {
        // Check if any users are using this VIP level
        if ($vipLevel->users()->count() > 0) {
            return back()->with('error', 'Không thể xóa VIP Level này vì có người dùng đang sử dụng!');
        }

        $vipLevel->delete();
        return redirect()->route('admin.vip.index')->with('success', 'VIP Level đã được xóa thành công!');
    }

    public function toggle(VipLevel $vipLevel)
    {
        $vipLevel->update(['is_active' => !$vipLevel->is_active]);
        
        $status = $vipLevel->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        return back()->with('success', "VIP Level đã được {$status} thành công!");
    }

    // Update all users VIP levels based on their total deposits
    public function updateAllUserVipLevels()
    {
        $users = User::all();
        $updated = 0;

        foreach ($users as $user) {
            $oldVipLevel = $user->vip_level_id;
            $user->updateVipLevel();
            
            if ($user->vip_level_id !== $oldVipLevel) {
                $updated++;
            }
        }

        return back()->with('success', "Đã cập nhật VIP level cho {$updated} người dùng!");
    }

    // Statistics
    public function statistics()
    {
        $stats = [];
        $vipLevels = VipLevel::withCount('users')->get();
        
        foreach ($vipLevels as $level) {
            $stats[] = [
                'level' => $level,
                'user_count' => $level->users_count,
                'total_deposits' => $level->users()->sum('total_deposit'),
            ];
        }

        return view('admin.vip.statistics', compact('stats'));
    }
}
<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VipLevel;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class VipController extends Controller
{
    /**
     * Hiển thị danh sách VIP levels
     */
    public function index()
    {
        $vipLevels = VipLevel::orderBy('level', 'asc')->get();
        return view('cpanel.vip.index', compact('vipLevels'));
    }

    /**
     * Tạo VIP level mới
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:0|unique:vip_levels',
            'required_deposit' => 'required|numeric|min:0',
            'benefits' => 'nullable|array',
            'color' => 'nullable|string|max:7',
        ], [
            'name.required' => 'Tên VIP level là bắt buộc',
            'level.required' => 'Level là bắt buộc',
            'level.unique' => 'Level này đã tồn tại',
            'required_deposit.required' => 'Số tiền yêu cầu là bắt buộc',
            'required_deposit.numeric' => 'Số tiền phải là số',
            'required_deposit.min' => 'Số tiền phải lớn hơn 0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $vipLevel = VipLevel::create([
            'name' => $request->name,
            'level' => $request->level,
            'required_deposit' => $request->required_deposit,
            'benefits' => $request->benefits ?? [],
            'icon' => $request->icon,
            'color' => $request->color ?? '#ffffff',
            'is_active' => $request->has('is_active')
        ]);

        return response()->json([
            'message' => 'VIP Level đã được tạo thành công',
            'vip_level' => $vipLevel
        ], 201);
    }

    /**
     * Hiển thị form chỉnh sửa VIP level
     */
    public function show($id)
    {
        $vipLevel = VipLevel::findOrFail($id);
        return view('cpanel.vip.show', compact('vipLevel'));
    }

    /**
     * Cập nhật VIP level
     */
    public function update(Request $request, $id)
    {
        $vipLevel = VipLevel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:0|unique:vip_levels,level,' . $id,
            'required_deposit' => 'required|numeric|min:0',
            'benefits' => 'nullable|array',
            'color' => 'nullable|string|max:7',
        ], [
            'name.required' => 'Tên VIP level là bắt buộc',
            'level.required' => 'Level là bắt buộc',
            'level.unique' => 'Level này đã tồn tại',
            'required_deposit.required' => 'Số tiền yêu cầu là bắt buộc',
            'required_deposit.numeric' => 'Số tiền phải là số',
            'required_deposit.min' => 'Số tiền phải lớn hơn 0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $vipLevel->update([
            'name' => $request->name,
            'level' => $request->level,
            'required_deposit' => $request->required_deposit,
            'benefits' => $request->benefits ?? [],
            'icon' => $request->icon,
            'color' => $request->color ?? '#ffffff',
            'is_active' => $request->has('is_active')
        ]);

        return response()->json([
            'message' => 'VIP Level đã được cập nhật thành công',
            'vip_level' => $vipLevel
        ], 200);
    }

    /**
     * Xóa VIP level
     */
    public function destroy($id)
    {
        $vipLevel = VipLevel::findOrFail($id);
        
        // Kiểm tra xem có user nào đang sử dụng VIP level này không
        $usersCount = User::where('vip_level_id', $id)->count();
        if ($usersCount > 0) {
            return response()->json([
                'error' => 'Không thể xóa VIP Level này vì có ' . $usersCount . ' người dùng đang sử dụng'
            ], 422);
        }

        $vipLevel->delete();

        return response()->json([
            'message' => 'VIP Level đã được xóa thành công'
        ], 200);
    }

    /**
     * Bật/tắt trạng thái VIP level
     */
    public function toggleStatus($id)
    {
        $vipLevel = VipLevel::findOrFail($id);
        $vipLevel->is_active = !$vipLevel->is_active;
        $vipLevel->save();

        return response()->json([
            'message' => 'Trạng thái VIP Level đã được cập nhật',
            'is_active' => $vipLevel->is_active
        ], 200);
    }

    /**
     * Cập nhật VIP level cho tất cả users dựa trên tổng nạp tiền
     */
    public function updateAllUsersVip()
    {
        $users = User::all();
        $updatedCount = 0;

        foreach ($users as $user) {
            $oldVipLevelId = $user->vip_level_id;
            $user->updateVipLevel();
            
            if ($user->vip_level_id != $oldVipLevelId) {
                $updatedCount++;
            }
        }

        return response()->json([
            'message' => "Đã cập nhật VIP level cho {$updatedCount} người dùng"
        ], 200);
    }

    /**
     * Lấy thống kê VIP levels
     */
    public function getStats()
    {
        $vipLevels = VipLevel::withCount('users')->orderBy('level')->get();
        
        $stats = [
            'total_vip_levels' => $vipLevels->count(),
            'active_vip_levels' => $vipLevels->where('is_active', true)->count(),
            'total_vip_users' => User::whereNotNull('vip_level_id')->count(),
            'levels_breakdown' => $vipLevels->map(function ($level) {
                return [
                    'name' => $level->name,
                    'level' => $level->level,
                    'users_count' => $level->users_count,
                    'required_deposit' => $level->required_deposit,
                    'is_active' => $level->is_active
                ];
            })
        ];

        return response()->json($stats);
    }

    /**
     * Tải lên icon cho VIP level
     */
    public function uploadIcon(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'icon.required' => 'Vui lòng chọn file icon',
            'icon.image' => 'File phải là hình ảnh',
            'icon.mimes' => 'Chỉ chấp nhận file jpeg, png, jpg, gif',
            'icon.max' => 'File không được vượt quá 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $vipLevel = VipLevel::findOrFail($id);

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = 'vip_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Tạo thư mục nếu chưa tồn tại
            $uploadPath = public_path('images/vip');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $file->move($uploadPath, $filename);
            
            // Xóa icon cũ nếu có
            if ($vipLevel->icon && file_exists($uploadPath . '/' . $vipLevel->icon)) {
                unlink($uploadPath . '/' . $vipLevel->icon);
            }
            
            $vipLevel->icon = $filename;
            $vipLevel->save();

            return response()->json([
                'message' => 'Icon đã được cập nhật thành công',
                'icon_url' => $vipLevel->icon_url
            ], 200);
        }

        return response()->json(['error' => 'Không có file được tải lên'], 422);
    }
}
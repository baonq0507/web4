<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConfigSystem;
use Illuminate\Support\Facades\Artisan;
class SystemConfigurationController extends Controller
{
    public function index()
    {
        $config = ConfigSystem::all();
        return view('cpanel.system-configuration', compact('config'));
    }

    public function save(Request $request)
    {
        $config = ConfigSystem::all();
        foreach ($config as $item) {
            switch ($item->key) {
                case 'app_logo':
                    //upload file
                    if ($request->hasFile('app_logo')) {
                        $file = $request->file('app_logo');
                        $filename = time() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('images/app'), $filename);
                        $item->value = $filename;
                    }
                    break;
                case 'app_logo2':
                    //upload file
                    if ($request->hasFile('app_logo2')) {
                        $file = $request->file('app_logo2');
                        $filename = time() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('images/app'), $filename);
                        $item->value = $filename;
                    }
                    break;
                case 'app_thumbnail':
                    //upload file
                    if ($request->hasFile('app_thumbnail')) {
                        $file = $request->file('app_thumbnail');
                        $filename = time() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('images/app'), $filename);
                        $item->value = $filename;
                    }
                    break;
                case 'app_favicon':
                    //upload file
                    if ($request->hasFile('app_favicon')) {
                        $file = $request->file('app_favicon');
                        $filename = time() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('images/app'), $filename);
                        $item->value = $filename;
                    }
                    break;
                case 'chart_background':
                    //upload file
                    if ($request->hasFile('chart_background')) {
                        $file = $request->file('chart_background');
                        $filename = time() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('images/app'), $filename);
                        $item->value = $filename;
                    }
                    break;
                case 'image_notification':
                    //upload file
                    if ($request->hasFile('image_notification')) {
                        $file = $request->file('image_notification');
                        $filename = time() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('images/app'), $filename);
                        $item->value = $filename;
                    }
                    break;
                default:
                    $item->value = $request->input($item->key);
                    break;
            }

            $item->save();
        }

        //run command
        Artisan::call('config:clear');

        return redirect()->route('cpanel.system-configuration')->with('success', __('index.system_configuration_saved'));
    }
}

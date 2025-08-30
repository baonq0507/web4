<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;
class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('cpanel.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('cpanel.projects.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'min_invest' => 'required|numeric|min:0',
            'max_invest' => 'required|numeric|min:0',
            'total_period' => 'required|numeric|min:0',
            'interval' => 'required',
            'profit' => 'required|numeric|min:0',
            'payback' => 'required|numeric|min:0',
            'status' => 'required',
        ]);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/projects'), $imageName);
            $path = 'images/projects/' . $imageName;
            $data['image'] = $path;
        } else {
            $data['image'] = null;
        }

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        
        $project = Project::create($data);
        return response()->json(['message' => __('index.project_created_successfully'), 'project' => $project]);
    }

    public function edit(Project $project)
    {
        $project = Project::find($project->id);
        return view('cpanel.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'min_invest' => 'required|numeric|min:0',
            'max_invest' => 'required|numeric|min:0',
            'total_period' => 'required|numeric|min:0',
            'interval' => 'required',
            'profit' => 'required|numeric|min:0',
            'payback' => 'required|numeric|min:0',
            'status' => 'required',
        ], [
            'name.required' => __('index.name_required'),
            'image.required' => __('index.image_required'),
            'min_invest.required' => __('index.min_invest_required'),
            'max_invest.required' => __('index.max_invest_required'),
            'total_period.required' => __('index.total_period_required'),
            'interval.required' => __('index.interval_required'),
            'profit.required' => __('index.profit_required'),
            'payback.required' => __('index.payback_required'),
            'status.required' => __('index.status_required'),
            'image.image' => __('index.image_image'),
            'image.mimes' => __('index.image_mimes'),
            'image.max' => __('index.image_max'),
        ]);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $url = asset('uploads/' . $filename);
            $data['image'] = $url;
        }

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $project->update($data);
        return response()->json(['message' => __('index.project_updated_successfully'), 'project' => $project]);
    }
}

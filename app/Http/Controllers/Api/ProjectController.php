<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $data = Project::all();
        return $data->toJson();
    }

    public function show($id)
    {
        $data = Project::where('id', $id)->first();
        if ($data !== null) {
            return $data->toJson();
        } else {
            return response('Запись не найдена', 404);
        }
    }

    public function destroy($id)
    {
        if (Project::where('id', $id)->first()->delete()) {
            return 1;
        } else {
            return response('Запись не найдена', 404);
        }
    }

    public function store(Request $request)
    {
        if (Project::create($request->post())) {
            return response('Запись добавлена', 201);
        } else {
            return response('Запись не найдена', 404);
        }
    }

    public function update(Request $request, $id)
    {
        $oldData = Project::where('id', $id)->first();
        if ($oldData !== null) {
            $oldData->update($request->all());
            return response('Запись обновлена', 202);
        } else {
            return response('Запись не найдена', 404);
        }
    }
}

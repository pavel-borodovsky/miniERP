<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $data = Invoice::all();
        return $data->toJson();
    }

    public function show($id)
    {
        $data = Invoice::where('id', $id)->first();
        if ($data !== null) {
            return $data->toJson();
        } else {
            return response('Запись не найдена', 404);
        }
    }

    public function destroy($id)
    {
        if (Invoice::where('id', $id)->first()->delete()) {
            return 1;
        } else {
            return response('Запись не найдена', 404);
        }
    }

    public function store(Request $request)
    {
        if (Invoice::create($request->post())) {
            return response('Запись добавлена', 201);
        } else {
            return response('Запись не найдена', 404);
        }
    }

    public function update(Request $request, $id)
    {
        $oldData = Invoice::where('id', $id)->first();
        if ($oldData !== null) {
            $oldData->update($request->all());
            return response('Запись обновлена', 202);
        } else {
            return response('Запись не найдена', 404);
        }
    }
}

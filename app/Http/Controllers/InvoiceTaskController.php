<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InvoiceTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $invoiceTasks = InvoiceTask::all();
        return view('invoicetasks', ['invoiceTasks' => $invoiceTasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $invoices = Invoice::all();
        return view('invoicetask-create', ['invoices' => $invoices]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required',
            'desc' => 'required',
        ]);

        InvoiceTask::create($request->post());
        return redirect()->route('invoice_tasks.index')->with('success','Invoice task has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceTask
     * @return \Illuminate\View\View
     */
    public function edit(InvoiceTask $invoice_task)
    {
        $invoices = Invoice::all();
        return view('invoicetask-edit', ['invoice_task' => $invoice_task, 'invoices' => $invoices]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceTask
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, InvoiceTask $invoice_task)
    {
        $request->validate([
            'invoice_id' => 'required',
            'desc' => 'required',
        ]);

        $invoice_task->update($request->except(['_token', '_method']));
        return Redirect::route('invoice_tasks.index')->with('success','Invoice task has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceTask
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(InvoiceTask $invoice_task)
    {
        if($invoice_task->incomeRates()->count() == 0 && $invoice_task->listCards()->count() == 0) {
            $invoice_task->delete();
            return redirect()->route('invoice_tasks.index')->with('success','Invoice task has been deleted successfully');
        } else {
            return redirect()->route('invoice_tasks.index')->with('danger','Oops, this invoice task has related records');
        }
    }
}

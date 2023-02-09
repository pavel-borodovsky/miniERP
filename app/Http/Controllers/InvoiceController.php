<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices', ['invoices' => $invoices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $projects = Project::all();
        return view('invoices-create', ['projects' => $projects]);
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
            'name' => 'string|nullable',
            'date' => 'required|date',
            'project_id' => 'required'
        ]);

        Invoice::create($request->post());
        return redirect()->route('invoices.index')->with('success','Invoice has been created successfully.');
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
     * @param  \App\Models\Invoice
     * @return \Illuminate\View\View
     */
    public function edit(Invoice $invoice)
    {
        $projects = Project::all();
        return view('invoices-edit', ['invoice' => $invoice, 'projects' => $projects]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'name' => 'string|nullable',
            'date' => 'required|date',
            'project_id' => 'required'
        ]);

        $invoice->update($request->except(['_token', '_method']));
        return Redirect::route('invoices.index')->with('success','Invoice has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Invoice $invoice)
    {
        if($invoice->invoice_tasks()->count() == 0) {
            $invoice->delete();
            return redirect()->route('invoices.index')->with('success','Project has been deleted successfully');
        } else {
            return redirect()->route('invoices.index')->with('danger','Oops, this invoice has related invoice tasks');
        }
    }
}

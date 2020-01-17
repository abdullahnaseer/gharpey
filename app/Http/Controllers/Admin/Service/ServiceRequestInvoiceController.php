<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreAndUpdateServiceRequestInvoiceRequest;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestInvoice;
use App\Models\ServiceRequestInvoiceDetail;
use App\Models\Seo;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Referral;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceRequestInvoiceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\ServiceRequest $serviceRequest
     * @param  \App\Http\Requests\Admin\StoreAndUpdateServiceRequestInvoiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAndUpdateServiceRequestInvoiceRequest $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validated();
        $invoice = ServiceRequestInvoice::create([
            'request_id' => $serviceRequest->id,
            'description' => $validated['description']
        ]);

        // Create invoices
        for($i = 0; $i < $request['count']; $i++){
            if(isset($validated['detail'][$i])){
                 $invoiceDetail = ServiceRequestInvoiceDetail::create([
                    'invoice_id' => (int) $invoice->id,
                    'detail' => $validated['detail'][$i],
                    'cost' => $validated['cost'][$i],
                    'quantity' => ($validated['quantity'][$i]) ? $validated['quantity'][$i] : null
                ]);
            }
        }

        if(isset($validated['mail']) && $validated['mail'])
            $serviceRequest->user->notify(new \App\Notifications\ServiceRequestInvoice($invoice));
        return redirect('/admin/service-requests/showInvoice/'.$serviceRequest->id)->with('status', 'Invoice is created successfully!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ServiceRequestInvoice  $serviceRequestInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceRequestInvoice $serviceRequestInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceRequestInvoice  $serviceRequestInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceRequestInvoice $serviceRequestInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\StoreAndUpdateServiceRequestInvoiceRequest  $request
     * @param \App\Models\ServiceRequest $serviceRequest
     * @param  \App\Models\ServiceRequestInvoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAndUpdateServiceRequestInvoiceRequest $request, ServiceRequest $serviceRequest, ServiceRequestInvoice $invoice)
    {
        $validated = $request->validated();
        $invoice->details()->delete();
        $invoice->update(['description' => $validated['description']]);
        // Update invoices
        for($i = 0; $i < $request['count']; $i++){
            if(isset($validated['detail'][$i])){
                $invoiceDetail = ServiceRequestInvoiceDetail::create([
                    'invoice_id' => (int) $invoice->id,
                    'detail' => $validated['detail'][$i],
                    'cost' => $validated['cost'][$i],
                    'quantity' => ($validated['quantity'][$i]) ? $validated['quantity'][$i] : null
                ]);
            }
        }

        if(isset($validated['mail']) && $validated['mail'])
            $serviceRequest->user->notify(new \App\Notifications\ServiceRequestInvoice($invoice));
        return redirect('/admin/service-requests/showInvoice/'.$serviceRequest->id)->with('status', 'Invoice is updated successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceRequestInvoice  $serviceRequestInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceRequestInvoice $serviceRequestInvoice)
    {
        //
    }

     /**
     * Change the commission.
     *
     * @param  \App\Models\ServiceRequestInvoice  $serviceRequestInvoice
     * @return \Illuminate\Http\Response
     */
    public function invoicePaid($id)
    {
        $serviceRequestInvoice = ServiceRequestInvoice::findOrFail($id);
        $serviceRequestInvoice->update([
            'paid_at' => Carbon::now()
        ]);

        $amount = $serviceRequestInvoice->details()->select(\DB::raw('sum(cost * COALESCE(quantity, 1)) as total'))->first()->total;

        \App\Models\Transaction::create([
            'user_id' => (int) $serviceRequestInvoice->request->user_id,
            'reference_id' => $serviceRequestInvoice->id,
            'reference_type' => \App\Models\ServiceRequestInvoice::class,
            'type' => \App\Models\Transaction::TYPE_CREDIT,
            'amount' => $amount,
            'balance' => $serviceRequestInvoice->request->user->transactions()->sum('amount') + $amount,
            'note' => '',
        ]);

        \App\Models\Transaction::create([
            'user_id' => (int) $serviceRequestInvoice->request->user_id,
            'reference_id' => $serviceRequestInvoice->id,
            'reference_type' => \App\Models\ServiceRequestInvoice::class,
            'type' => \App\Models\Transaction::TYPE_DEBIT,
            'amount' => -$amount,
            'balance' => $serviceRequestInvoice->request->user->transactions()->sum('amount') - $amount,
            'note' => '',
        ]);

        return redirect('/admin/service-requests/showInvoice/'.$serviceRequestInvoice->request_id)->with('status', 'Paid successfully!!!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Notifications\ServiceRequestQuoteCreated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Storage;

class ServiceRequestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:' . User::ADMIN);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $requests = ServiceRequest::with('answers', 'location', 'location.city')->paginate(50);
        return view('admin.services.requests.index', ['requests' => $requests]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param ServiceRequest $serviceRequest
     * @return Response
     */
    public function show($id)
    {
        $serviceRequest = ServiceRequest::where('id', (int)$id)
            ->with('service', 'answers', 'answers.answer', 'location', 'location.city', 'quote', 'invoices', 'invoices.details')
            ->firstOrFail();
        return view('admin.services.requests.show', ['request' => $serviceRequest]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ServiceRequest $serviceRequest
     * @return Response
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ServiceRequest $serviceRequest
     * @return Response
     */
    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ServiceRequest $serviceRequest
     * @return Response
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        foreach ($serviceRequest->answers as $answer) {
//            if($answer->answer_type == \App\Models\ServiceRequestAnswerFile::class)
            $answer->answer()->delete();
        }
        Storage::deleteDirectory('public/service-requests/' . $serviceRequest->id);
        $serviceRequest->delete();
        return redirect('/admin/service-requests')->with('status', 'Service Request is deleted successfully!!!');
    }

    /**
     * Show the invoice list.
     *
     * @param user_id
     * @return Response
     */
    public function showInvoice($id)
    {
        $serviceRequest = ServiceRequest::where('id', (int)$id)
            ->with('invoices', 'invoices.details')
            ->firstOrFail();
        return view('admin.services.requests.invoices.show', ['request' => $serviceRequest]);
    }


    /**
     * Update the specified resource in storage and mark it complete.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function confirm(Request $request, $id)
    {
        $serviceRequest = ServiceRequest::findOrFail((int)$id);
        if (is_null($serviceRequest->completed_at)
            && $serviceRequest->invoices()->count()
            && $serviceRequest->invoices()->whereNull('paid_at')->count() == 0) {
            $serviceRequest->update(['completed_at' => Carbon::now()]);
            return redirect('/admin/service-requests')->with('status', 'Service Request has been marked complete successfully!!!');
        }
        return redirect('/admin/service-requests')->with('error', 'Service Request cant be marked complete!!!');

    }

}

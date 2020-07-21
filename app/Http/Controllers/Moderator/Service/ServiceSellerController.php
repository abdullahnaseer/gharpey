<?php

namespace App\Http\Controllers\Moderator\Service;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOrder;
use App\Models\Seller;
use App\Models\ServiceSeller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Str;

class ServiceSellerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin,moderator');
    }

    /**
     * Return a listing of the resource.
     *
     * @param Request $request
     * @return mixed
     */
    public function json(Request $request)
    {
        $seller_id = $request->input('seller_id');

        if(!is_null($seller_id)) {
            $service_sellers = Seller::findOrFail($seller_id)->services()->with([])->get();
        } else {
            $service_sellers = ServiceSeller::with([
                'service'
            ])->get();
        }

        return $service_sellers;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('moderator.services.sellers.index');
    }

    /**
     * Display the resource.
     *
     * @return mixed
     */
    public function show()
    {
        return "Not Implemented";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $record_id
     * @return mixed
     */
    public function destroy(Request $request, int $record_id)
    {
        $record = ServiceSeller::findOrFail($record_id);
        $record->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('moderator.service_sellers.index');
    }
}

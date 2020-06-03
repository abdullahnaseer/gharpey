<?php

namespace App\Http\Controllers\Seller\Service;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceQuestion;
use App\Models\ServiceQuestionChoices;
use App\Models\ServiceSeller;
use App\Models\State;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Str;

class ServiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:seller');
        $this->middleware('seller.approved');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function json()
    {
        $records = auth('seller')->user()->services()->with([])->get();
        foreach ($records as $record)
            $record->cities = ServiceSeller::find($record->pivot->id)->cities->implode("id", ",");
        return $records;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('seller.services.index', [
            'services' => Service::whereNotIn('id',
                ServiceSeller::where('seller_id',
                    auth('seller')->id()
                )->get()->pluck('service_id')
            )->get(),
            'cities' => City::all()
        ]);
    }

    /**
     * Display create page of the resource.
     *
     * @return Response
     */
    public function create()
    {
        // Only Retrieve services which are not already offered by authenticated seller
        $services = auth()->user()->services()->get()->pluck('id');

        $categories = ServiceCategory::has('services')->with(['services' => function ($query) use ($services) {
            $query->whereNotIn('id', $services);
        }])->get();

        return view('seller.services.create', [
            'categories' => $categories,
            'states' => State::with(['cities'])->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate(Service::getRules($request));

        $fields = $request->only(['service_id', 'short_description', 'long_description', 'price']);
        $fields['featured_image'] = $request->file('featured_image')->store('public/services');
        $fields['seller_id'] = auth('seller')->id();

        $serviceSeller = ServiceSeller::create($fields);
        $serviceSeller->cities()->sync($request->input('cities'));

        for ($i = 0, $iMax = count($request->input('name', [])); $i < $iMax; $i++) {
            $question = $serviceSeller->questions()->create([
                'order_priority' => $i + 1,
                'name' => $request->input('name')[$i],
                'question' => $request->input('question')[$i],
                'type' => $request->input('type')[$i],
//                'is_required' => $request->input('is_required', [])[$i] === '1',
//                'auth_rule' => $request->input('auth_type', [])[$i]
            ]);

            if ($question->type->isSelect()) {
                $k = 1;
                foreach ($request->input('choices.' . $i) as $choice) {
                    $choice = ServiceQuestionChoices::create([
                        'order_priority' => $k++,
                        'question_id' => $question->id,
                        'choice' => $choice,
                        'price_change' => $request->input('choices.' . $i . '.' . $k)
                    ]);
                    $k++;
                }
            }
        }

        flash('Successfully created the new record!')->success();
        return redirect()->route('seller.services.index');
    }

    /**
     * Display edit page of the resource.
     *
     * @return mixed
     */
    public function edit($record_id)
    {
        $record = ServiceSeller::where('seller_id', auth('seller')->id())
            ->where('service_id', $record_id)
            ->with(['seller', 'service'])
            ->firstOrFail();

        // Only Retrieve services which are not already offered by authenticated seller
        $services = auth()->user()->services()->get()->pluck('id');

        $categories = ServiceCategory::has('services')->with(['services' => function ($query) use ($services) {
            $query->whereNotIn('id', $services);
        }])->get();

        return view('seller.services.create', [
            'service_seller' => $record,
            'categories' => $categories,
            'states' => State::with(['cities'])->get()
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $record_id
     * @return RedirectResponse
     */
    public function update(Request $request, int $record_id)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id|unique:service_seller,service_id,' . $record_id . ',service_id,seller_id,' . auth()->id(),
            'price' => 'required|numeric|min:100|max:20000',
            'description' => 'required|min:10|max:1000',
            'cities' => 'required|exists:cities,id',
            'featured_image' => 'required|file|image',
        ]);

        $record = ServiceSeller::where('seller_id', auth('seller')->id())
            ->where('service_id', $record_id)
            ->firstOrFail();

        $fields = $request->only(['service_id', 'name', 'description', 'price']);
        $fields['seller_id'] = auth('seller')->id();
        if ($request->hasFile('featured_image'))
            $fields['featured_image'] = $request->file('featured_image')->store('public/services');

        $record->update($fields);
        $record->states()->sync($request->input('cities'));

        flash('Successfully modified the record!')->success();
        return redirect()->route('seller.services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $record_id
     * @return RedirectResponse
     */
    public function destroy(Request $request, int $record_id)
    {
        $record = ServiceSeller::where('seller_id', auth('seller')->id())
            ->where('service_id', $record_id)
            ->firstOrFail();
        $record->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('seller.services.index');
    }
}

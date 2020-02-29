<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceQuestion;
use App\Models\ServiceQuestionChoices;
use App\Rules\Phone;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
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
        $this->middleware('auth:admin');
    }

    /**
     * Return a listing of the resource.
     *
     * @return Response
     */
    public function json()
    {
        $records = Service::with([])->get();
        return $records;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = ServiceCategory::all();
        return view('admin.services.index', ['categories' => $categories]);
    }

    /**
     * Display create page of the resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = ServiceCategory::all();
        return view('admin.services.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate(Service::getRules($request));

        $fields = $request->only(['name', 'description', 'category_id']);
        $fields['featured_image'] = $request->file('featured_image')->store('public/services');

        $service = Service::create($fields);
        $service->update(['slug' => \Illuminate\Support\Str::slug($service->name . ' ' . $service->id)]);

        for ($i = 0, $iMax = count($request->input('title', [])); $i < $iMax; $i++)
        {
            $question = $service->questions()->create([
                'order_priority' => $i + 1,
                'title' => $request->input('title')[$i],
                'question' => $request->input('question')[$i],
                'type' => $request->input('type')[$i],
                'is_required' => $request->input('is_required', [])[$i] === '1',
                'auth_rule' => $request->input('auth_type', [])[$i]
            ]);

            if($request->input('type')[$i] === ServiceQuestion::TYPE_SELECT || $request->input('type')[$i] === ServiceQuestion::TYPE_SELECT_MULTIPLE)
            {
                $k = 1;
                foreach ($request->input('choices.'.$i) as $choice) {
                    $choice = ServiceQuestionChoices::create([
                        'order_priority' => $k++,
                        'question_id' => $question->id,
                        'choice' => $choice,
                    ]);
                }
            }
        }

        flash('Successfully created the new record!')->success();
        return redirect()->route('admin.services.index');
    }

    /**
     * Display edit page of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($service_id)
    {
        $service = Service::with(['category', 'questions', 'questions.choices'])->findOrFail($service_id);
        $categories = ServiceCategory::all();
        return view('admin.services.edit', ['service' => $service, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $record_id
     * @return Response
     */
    public function update(Request $request, int $record_id)
    {
        $request->validate(Service::getRules($request, true));

        $record = Service::findOrFail($record_id);

        $fields = $request->only(['name', 'description', 'category_id']);
        $fields['slug'] = \Illuminate\Support\Str::slug($record->name . ' ' . $record->id);
        if($request->hasFile('featured_image'))
            $fields['featured_image'] = $request->file('featured_image')->store('public/services');

        $record->update($fields);

        ServiceQuestion::whereNotIn('id', $request->input('question_id'))->delete();

        for ($i = 0, $iMax = count($request->input('title', [])); $i < $iMax; $i++)
        {
            $question = null;
            if(!is_null($request->input('question_id')[$i]))
            {
                $question = ServiceQuestion::find($request->input('question_id')[$i]);
                if($request->input('type')[$i] == $question->type)
                {
                    $question->update([
                        'order_priority' => $i + 1,
                        'title' => $request->input('title')[$i],
                        'question' => $request->input('question')[$i],
                        'is_required' => $request->input('is_required', [])[$i] === '1',
                        'auth_rule' => $request->input('auth_type', [])[$i]
                    ]);

                    if($request->input('type')[$i] === ServiceQuestion::TYPE_SELECT || $request->input('type')[$i] === ServiceQuestion::TYPE_SELECT_MULTIPLE)
                        $question->choices()->delete();
                }
            } else {
                $question = $record->questions()->create([
                    'order_priority' => $i + 1,
                    'title' => $request->input('title')[$i],
                    'question' => $request->input('question')[$i],
                    'type' => $request->input('type')[$i],
                    'is_required' => $request->input('is_required', [])[$i] === '1',
                    'auth_rule' => $request->input('auth_type', [])[$i]
                ]);
            }

            if($request->input('type')[$i] === ServiceQuestion::TYPE_SELECT || $request->input('type')[$i] === ServiceQuestion::TYPE_SELECT_MULTIPLE)
            {
                $k = 1;
                foreach ($request->input('choices.'.$i) as $choice) {
                    $choice = ServiceQuestionChoices::create([
                        'order_priority' => $k++,
                        'question_id' => $question->id,
                        'choice' => $choice,
                    ]);
                }
            }
        }

        flash('Successfully modified the record!')->success();
        return redirect()->route('admin.services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $record_id
     * @return Response
     */
    public function destroy(Request $request, int $record_id)
    {
        $record = Service::findOrFail($record_id);
        $record->delete();
        flash('Successfully deleted the record!')->success();

        return redirect()->route('admin.services.index');
    }
}

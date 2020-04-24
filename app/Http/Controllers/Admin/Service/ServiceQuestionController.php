<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceQuestionRequest;
use App\Http\Requests\Admin\UpdateServiceQuestionRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Models\Seo;
use App\Models\ServiceQuestion;
use App\Models\ServiceQuestionChoices;
use App\Models\ServiceQuestionValidationRule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceQuestionController extends Controller
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
        $questions = ServiceQuestion::with('services')->paginate();
        $baseUrl = url('/');
        $currentUrl = url()->current();
        $currentUrl = str_replace($baseUrl, "", $currentUrl);
        $seo = Seo::where('url', '=', 'https://servicedbyone.com' . $currentUrl)->first();
        return view('admin.services.questions.index', ['questions' => $questions, 'seo' => $seo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.services.questions.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreServiceQuestionRequest $request)
    {
        $validated = $request->validated();
        $question = ServiceQuestion::create([
            'name' => $validated['name'],
            'question' => $validated['question'],
            'type' => $validated['type']
        ]);

        $this->syncRoles($request, $question);

        if (isset($validated['choices'])) {
            foreach ($validated['choices'] as $choice) {
                $choice = ServiceQuestionChoices::create([
                    'question_id' => $question->id,
                    'choice' => $choice,
                ]);
            }
        }

        return redirect('/admin/service-questions')->with('status', 'Service Question is created successfully!!!');
    }

    private function syncRoles($request, ServiceQuestion $question)
    {
        $rules = [];
        if ($request->input('is_required', false))
            array_push($rules, (int)ServiceQuestionValidationRule::where('rule', ServiceQuestionValidationRule::REQUIRED)->first()->id);
        if ($request->input('is_only_for_guest', false))
            array_push($rules, (int)ServiceQuestionValidationRule::where('rule', ServiceQuestionValidationRule::AUTH_GUEST)->first()->id);
        if ($request->input('is_only_for_authenticated', false))
            array_push($rules, (int)ServiceQuestionValidationRule::where('rule', ServiceQuestionValidationRule::AUTH_REQUIRED)->first()->id);
        if (!$request->input('is_only_for_guest', false) && !$request->input('is_only_for_authenticated', false))
            array_push($rules, (int)ServiceQuestionValidationRule::where('rule', ServiceQuestionValidationRule::AUTH_ANY)->first()->id);
        $question->rules()->sync($rules);

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param ServiceQuestion $serviceQuestion
     * @return Response
     */
    public function show(ServiceQuestion $serviceQuestion)
    {
        return view('admin.services.questions.show', ['question' => $serviceQuestion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ServiceQuestion $serviceQuestion
     * @return Response
     */
    public function edit(ServiceQuestion $serviceQuestion)
    {
        return view('admin.services.questions.edit', ['question' => $serviceQuestion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ServiceQuestion $serviceQuestion
     * @return Response
     */
    public function update(UpdateServiceQuestionRequest $request, ServiceQuestion $serviceQuestion)
    {
        $validated = $request->validated();
        $serviceQuestion->update([
            'name' => $validated['name'],
            'question' => $validated['question'],
            'type' => $validated['type'],
        ]);

        $this->syncRoles($request, $serviceQuestion);

        if (isset($validated['choices'])) {
            $temp = array();
            foreach ($validated['choices'] as $choice) {
                $c = $serviceQuestion->choices()->where('choice', $choice)->first();
                if (is_null($c)) {
                    $choice = ServiceQuestionChoices::create([
                        'question_id' => $serviceQuestion->id,
                        'choice' => $choice,
                    ]);
                    array_push($temp, $choice->id);
                } else {
                    array_push($temp, $c->id);
                }
            }
            $serviceQuestion->choices()->whereNotIn('id', $temp)->delete();
        } else {
            $serviceQuestion->choices()->delete();
        }

        return redirect('/admin/service-questions')->with('status', 'Service Question is updated successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ServiceQuestion $serviceQuestion
     * @return Response
     */
    public function destroy(ServiceQuestion $serviceQuestion)
    {
        $serviceQuestion->delete();
        return redirect('/admin/service-questions')->with('status', 'Service Question is deleted successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ServiceQuestion $serviceQuestion
     * @param ServiceQuestionChoices $serviceQuestionChoice
     * @return Response
     */
    public function destroyChoice($question_id, $question_choice_id)
    {
        ServiceQuestionChoices::findOrFail($question_choice_id)->delete();
        return redirect('/admin/service-questions/' . $question_id)->with('status', 'Service Question Choice is deleted successfully!!!');
    }

}

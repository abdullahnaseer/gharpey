<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Question;
use App\Models\ServiceSeller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QuestionController extends Controller
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
     * @return mixed
     */
    public function json()
    {
        $questions = Question::whereHasMorph(
            'item',
            [Product::class, ServiceSeller::class],
            fn (Builder $q) => $q->where('seller_id', auth('seller')->id())
        )->with(['item'])->get();

        $questions->each(fn($q) => $q->item_type == \App\Models\ServiceSeller::class ? ($q->item->name = $q->item->service->name) : true);

        return $questions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('seller.questions.index');
    }

    /**
     * Store answer for question.
     *
     * @return mixed
     */
    public function update(Request $request, Question $question)
    {
        $request->validate(['response' => ['required', 'min:5', 'max:1000']]);

        $question->update(['answer_description' => $request->input('response')]);

        flash("Response Saved Successfully!")->success();
        return redirect()->route('seller.questions.index');
    }
}

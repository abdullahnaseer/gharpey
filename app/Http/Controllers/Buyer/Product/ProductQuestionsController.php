<?php

namespace App\Http\Controllers\Buyer\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Question;
use Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Str;

class ProductQuestionsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Product $product
     * @return mixed
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'question_title' => ['required', 'min:3', 'max:100'],
            'question_description' => ['required', 'min:10', 'max:1000'],
        ]);

        $qas = $product->questions()->create([
            'buyer_id' => auth('buyer')->id(),
            'question_title' => $request->input('question_title'),
            'question_description' => $request->input('question_description'),
        ]);

        flash('Question created successfully!')->success();
        return redirect()->route('buyer.products.show', [$product->slug]);
    }
}

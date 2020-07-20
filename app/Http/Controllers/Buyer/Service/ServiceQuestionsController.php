<?php

namespace App\Http\Controllers\Buyer\Service;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceSeller;
use Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Str;

class ServiceQuestionsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $service_slug
     * @param $service_seller_id
     * @return mixed
     */
    public function store(Request $request, $service_slug, $service_seller_id)
    {
        $service = Service::where('slug', $service_slug)->firstOrFail();
        $service_seller = $service->service_sellers()->findOrFail($service_seller_id);

        $request->validate([
            'question_title' => ['required', 'min:3', 'max:100'],
            'question_description' => ['required', 'min:10', 'max:1000'],
        ]);

        $qas = $service_seller->service_questions()->create([
            'buyer_id' => auth('buyer')->id(),
            'question_title' => $request->input('question_title'),
            'question_description' => $request->input('question_description'),
        ]);

        flash('Question created successfully!')->success();
        return redirect()->route('buyer.services.sellers.show', [$service->slug, $service_seller->id]);
    }
}

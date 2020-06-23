<?php

namespace App\Http\Controllers\Seller;

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

class WithdrawController extends Controller
{
    /**
     * Return a listing of the resource.
     *
     * @return mixed
     */
    public function json()
    {
        return auth('seller')->user()->withdraws()->with([])->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('seller.withdraws');
    }
}

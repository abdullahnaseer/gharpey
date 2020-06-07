<?php

namespace App\Http\Controllers\Buyer\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $data['notifications'] = auth('buyer')->user()->notifications()->orderBy('created_at', 'desc')->get();
        return view('buyer.account.notifications', $data);
    }
}

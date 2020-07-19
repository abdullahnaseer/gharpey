<?php

namespace App\Http\Controllers\Buyer\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $data['tickets'] = auth('buyer')->user()->tickets()->orderBy('created_at', 'desc')->get();
        return view('buyer.account.support.index', $data);
    }

    /**
     * Show form for new support ticket.
     *
     * @return mixed
     */
    public function show($id)
    {
        $data['ticket'] = auth('buyer')->user()->tickets()->findOrFail((int) $id);
        return view('buyer.account.support.show', $data);
    }

    /**
     * Show form for new support ticket.
     *
     * @return mixed
     */
    public function create()
    {
        return view('buyer.account.support.create');
    }

    /**
     * Create new support ticket.
     *
     * @param $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'message' => ['required', 'min:3', 'max:2000'],
            'files' => ['array', 'max:10'],
            'files.*' => ['file', 'max:1000'],
        ]);

        $ticket = auth('buyer')->user()->tickets()->create($request->only(['title']));

        flash()->success('Support Ticket Created Successfully!');
        return redirect()->route('buyer.account.support.show', $ticket->id);
    }
}

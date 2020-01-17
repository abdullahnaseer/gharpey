<?php

namespace App\Http\Controllers\Admin;

use App\Models\Seo;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:'.User::ADMIN);
    }

    /**
     * Display a listing of the users who are eligible for withdraws.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $users = User::with('last_transaction')->get();
        return view('admin.payments.index', ['users' => $users]);
    }

    /**
     * Withdraws amount for selected users.
     *
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request)
    {
        $users = User::whereIn('id', $request->input('users', []))->with('last_transaction')->get();
        foreach($users as $user)
        {
            if($user->last_transaction->balance >= 100)
            {
                \App\Models\Transaction::create([
                    'user_id' => (int) $user->id,
                    'type' => \App\Models\Transaction::TYPE_DEBIT,
                    'amount' => -$user->last_transaction->balance,
                    'balance' => 0,
                    'note' => '',
                ]);
            }
        }

        return redirect('/admin/payments');
    }

}

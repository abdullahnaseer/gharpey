@extends('admin.layouts.dashboard', ['page_title' => "Dashboard"])

@section('breadcrumb')
    <a href="index.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
    <span class="breadcrumb-item active">Dashboard</span>
@endsection

@section('content')
    {!! Form::open(array('url' => '/admin/payments', 'method' => 'post')) !!}
    <h2>Sellers</h2>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>Select</th>
                <th>Seller ID</th>
                <th>Seller Name</th>
                <th>Payment Name</th>
                <th>Payment Bank</th>
                <th>Payment Threshold</th>
                <th>Withdrawable Amount (excluding fee)</th>
                <th>Payment Amount</th>
                <th>Fee Amount</th>
                <th>Paid Amount</th>
                <th>Options</th>
            </tr>
            @if($users->isEmpty())
                <tr>
                    <td colspan="3" style="text-align:center;">There are no payments or earnings for your search.</td>
                </tr>
            @else
                @foreach($users as $u)
                    <tr>
                        <td>
                            {!! Form::checkbox('users[]', $u->id) !!}
                        </td>
                        <td>{!! $u->id !!}</td>
                        <td>
                            <i><font color="green">
                                    {!! $u->name !!}
                                </font></i>
                        </td>
                        @if(is_null($u->payment_detail))
                            <td colspan="3" class="text-info">Payment Information Not Set</td>
                        @else
                            <td>{!! $u->payment_detail->name !!}</td>
                            <td>{!! $u->payment_detail->bank !!}</td>
                            <td>{!! $u->payment_detail->threshold !!}</td>
                        @endif
                        <td>{!! $u->withdrawable !!}</td>
                        <td>{!! $u->withdrawable - $u->fee !!}</td>
                        <td>{!! $u->fee !!}</td>
                        <td>{!! $u->total_withdrawn !!}</td>
                        <td><a href="{!! route( 'moderator.users.sellers.edit', [$u->id] ) !!}" target="_blank">View Account</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>

    {!! Form::submit('Pay', ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a class="btn btn-primary" href="{{ route('financials.create') }}">+Add</a>
            <div class="card m-2">                
                <div class="card-header">Transactions</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            @if(\Auth::user()->roles->first()->name == 'admin')
                                <th>User</th>
                            @endif
                            <th>Description</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th colspan=2>Action(s)</th>
                        </thead>
                        <tbody>
                            @foreach($transactions as $key=>$transaction)
                                <tr>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td>{{ $transaction->transaction_type }}</td>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->updated_at)->format('Y-m-d') }}</td>
                                    <td><a class="btn btn-primary" href="{{ route('financials.edit', $transaction->id) }}">Update</a></td>
                                    @if(\Auth::user()->roles->first()->name == 'admin')
                                        <form method="POST" action="{{ route('financials.destroy', $transaction->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <td><button type="submit" class="btn btn-danger">Delete</a></td>
                                        </form>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
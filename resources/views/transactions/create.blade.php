@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    @if(isset($transaction))
                        Edit 
                    @else
                        Create 
                    @endif
                    Transaction</div>
                <div class="card-body">
                <form method="POST" action="{{ (isset($transaction) ? route('financials.update', $transaction->id) : route('financials.store')) }}">
                        @csrf
                        @if(isset($transaction))
                            @method('PUT')
                        @endif
                        @if(\Auth::user()->roles->first()->name == 'admin')
                            <div class="row mb-3">
                                <label for="user_id" class="col-md-4 col-form-label text-md-end">User</label>

                                <div class="col-md-6">  
                                    <select id="user_id" class="form-select @error('user_id') is-invalid @enderror" name="user_id">
                                        @foreach($users as $user)
                                            <option {{ (isset($transaction) && $transaction->user_id == $user->id ? 'selected' : '') }} value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>                        
                        @endif
                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ (isset($transaction) ? $transaction->description : old('description')) }}" autofocus>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="transaction_type" class="col-md-4 col-form-label text-md-end">Type</label>

                            <div class="col-md-6">  
                                <select id="transaction_type" class="form-select @error('transaction_type') is-invalid @enderror" name="transaction_type">
                                    @foreach(App\Models\FinancialTransaction::TRANSACTION_TYPES as $type)
                                        <option {{ (isset($transaction) && $transaction->transaction_type == $type ? 'selected' : '') }} value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('transaction_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="amount" class="col-md-4 col-form-label text-md-end">Amount</label>

                            <div class="col-md-6">
                                <input id="amount" type="number" value="{{ (isset($transaction) ? $transaction->amount : old('amount')) }}" class="form-control @error('amount') is-invalid @enderror" name="amount" step="any">

                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($transaction) ? 'Update' : 'Create' }}
                                </button>
                                <a href="{{ route('financials.index') }}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

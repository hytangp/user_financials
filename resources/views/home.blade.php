@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card m-2">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in as <b>{{ \Auth::user()->roles->first()->name }}</b> role!
                </div>
            </div>

            <div class="card m-2">
                <div class="card-header">Navigation</div>

                <div class="card-body">
                    <a href="{{ route('financials.index') }}">Get financials</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

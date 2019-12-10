@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">The Big DB project</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="content">
                        <div class="links">
                            <a href="{{ route('trades') }}">Trades</a>
                            <a href="https://laravel-news.com">News</a>
                            <a href="https://blog.laravel.com">Blog</a>
                            <a href="https://nova.laravel.com">Nova</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

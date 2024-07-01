@extends('layouts.app')

@section('content')
    @switch ($role)
        @case('Ректор')
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Окно') }}</div>
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                {{ __('Статистика ректора!') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @break
        @case('Проректор')
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Окно') }}</div>
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                {{ __('Статистика проректора!') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @break
        @case('Директор')
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Окно') }}</div>
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                {{ __('Статистика директора!') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @break
        @case('Преподаватель')
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Окно') }}</div>
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                {{ __('Статистика преподавателя!') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @break
        @case('Менеджер')
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ __('Окно') }}</div>
                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                {{ __('Статистика менеджера!') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @break
        @default
        @break
    @endswitch
@endsection

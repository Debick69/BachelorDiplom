@extends('layouts.app')

@section('content')
        @foreach($notifications as $notification)
            <div class="container bg-light rounded border border-primary">
                <div class="row justify-content-center">
                    <div class="col text-center w-100 p-3 ">
                        <form>
                            <div class="rounded border border-secondary">
                                <p>Заголовок: {{ $notification->title }}</p>
                            </div>
                            <div class="rounded border border-secondary">
                                <p>Текст: {{ $notification->text }}</p>
                            </div>
                            <div class="rounded border border-secondary">
                                <p>Дата: {{ $notification->datetime }}</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="p-2"></div>
        @endforeach
@endsection

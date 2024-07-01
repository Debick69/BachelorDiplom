@extends('layouts.app')

@section('content')
    @switch ($role)
        @case('Ректор')
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            @if (Route::has('route_missions_missions_applications'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_applications') }}">{{ __('Заявки') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_tasks'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_tasks') }}">{{ __('Выполняющиеся_ИЗ') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_reports'))
                            <h3>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('route_missions_missions_reports') }}">{{ __('Отчеты') }}</a>
                                </li>
                            </h3>
                            @endif
                            @if (Route::has('route_missions_missions_edit'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_edit') }}">{{ __('Редактировать_ИЗ') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_create'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_create') }}">{{ __('Создать_ИЗ') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_approve'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_approve') }}">{{ __('Утвердить_ИЗ') }}</a>
                                    </li>
                                </h3>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            @break
        @case('Проректор')
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            @if (Route::has('route_missions_missions_applications'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_applications') }}">{{ __('Заявки') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_tasks'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_tasks') }}">{{ __('Выполняющиеся_ИЗ') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_reports'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_reports') }}">{{ __('Отчеты') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_edit'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_edit') }}">{{ __('Редактировать_ИЗ') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_create'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_create') }}">{{ __('Создать_ИЗ') }}</a>
                                    </li>
                                </h3>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            @break
        @case('Директор')
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            @if (Route::has('route_missions_missions_applications_teacher'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_applications_teacher') }}">{{ __('Подать_заявку') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_applications_teacher_mine'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_applications_teacher_mine') }}">{{ __('Свои_заявки') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_tasks_teacher'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_tasks_teacher') }}">{{ __('Выполняющиеся_ИЗ') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_reports_teacher_mine'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_reports_teacher_mine') }}">{{ __('Отчеты') }}</a>
                                    </li>
                                </h3>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            @break
        @case('Преподаватель')
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            @if (Route::has('route_missions_missions_applications_teacher'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_applications_teacher') }}">{{ __('Подать_заявку') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_applications_teacher_mine'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_applications_teacher_mine') }}">{{ __('Мои_заявки') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_tasks_teacher'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_tasks_teacher') }}">{{ __('Выполняющиеся_ИЗ') }}</a>
                                    </li>
                                </h3>
                            @endif
                            @if (Route::has('route_missions_missions_reports_teacher_mine'))
                                <h3>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('route_missions_missions_reports_teacher_mine') }}">{{ __('Отчеты') }}</a>
                                    </li>
                                </h3>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            @break
        @default
            @break
    @endswitch
    <main class="py-4">
        @yield('under-missions')
    </main>
@endsection

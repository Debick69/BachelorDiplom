@extends('missions.missions')

@section('under-missions')
    <div class="container">
        <div class="row">
            @if (Route::has('route_missions_applications'))
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/applications">
                        @csrf
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{"Заявки на рассмотрении"}}" name="applications_type" id="applications_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Заявки на рассмотрении</h4></button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/applications">
                        @csrf
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{"Отклоненные заявки"}}" name="applications_type" id="applications_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Отклоненные заявки</h4></button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/applications">
                        @csrf
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{"Принятые заявки проректором (ожидание подтверждения от преподавателя)"}}" name="applications_type" id="applications_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Принятые заявки проректором (ожидание подтверждения от преподавателя)</h4></button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/applications">
                        @csrf
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{"Принятые заявки проректором (подтверждено преподавателем)"}}" name="applications_type" id="applications_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Принятые заявки проректором (подтверждено преподавателем)</h4></button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/applications">
                        @csrf
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{"Принятые заявки проректором (одобрено ректором)"}}" name="applications_type" id="applications_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Принятые заявки проректором (одобрено ректором)</h4></button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    <h4 class="text-center">{{ $applications_type }}:</h4>
    @if($applications == null)
        <h5 class="text-center">{{ $applications_type }} отсутствуют!</h5>
    @else
        @switch($applications_type)
            @case("Заявки на рассмотрении")
                @foreach($applications as $application)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Преподаватель: {{ $application->name }}</h5>
                                <h6>Текст заявки: {{ $application->text }}</h6>
                                <p>Дата заявки: {{ $application->date }}</p>
                                @if (Route::has('route_missions_application'))
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                                <form method="post" action="/missions/application">
                                                    @csrf
                                                    <input type="hidden" value="{{ $application->id }}" name="application_id" id="application_id">
                                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                                    <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                                    <input type="hidden" value="{{ false }}" name="fault" id="fault">
                                                    <input type="hidden" value="{{ false }}" name="mxfault" id="mxfault">
                                                    <input type="hidden" value="{{ true }}" name="option" id="option">
                                                    <button type="submit" class="btn btn-success w-100"><h6>Принять</h6></button>
                                                </form>
                                            </div>
                                            <div class="col-sm">
                                                <form method="post" action="/missions/application">
                                                    @csrf
                                                    <input type="hidden" value="{{ $application->id }}" name="application_id" id="application_id">
                                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                                    <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                                    <input type="hidden" value="{{ false }}" name="fault" id="fault">
                                                    <input type="hidden" value="{{ false }}" name="mxfault" id="mxfault">
                                                    <input type="hidden" value="{{ false }}" name="option" id="option">
                                                    <button type="submit" class="btn btn-danger w-100"><h6>Отклонить</h6></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-2"></div>
                @endforeach
                @break
            @case ("Отклоненные заявки")
                @foreach($applications as $application)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Преподаватель: {{ $application->name }}</h5>
                                <h6>Текст заявки: {{ $application->text }}</h6>
                                <h6>Причина отказа: {{ $application->answer_text }}</h6>
                                <p>Дата заявки: {{ $application->date }}</p>
                                @if (Route::has('route_missions_application'))
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                                <form method="post" action="/missions/application">
                                                    @csrf
                                                    <input type="hidden" value="{{ $application->id }}" name="application_id" id="application_id">
                                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                                    <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                                    <input type="hidden" value="{{ false }}" name="mxfault" id="mxfault">
                                                    <input type="hidden" value="{{ false }}" name="fault" id="fault">
                                                    <button type="submit" class="btn btn-success w-100"><h6>Принять</h6></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-2"></div>
                @endforeach
                @break
            @case ("Принятые заявки проректором (ожидание подтверждения от преподавателя)")
                @foreach($applications as $application)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Преподаватель: {{ $application->name }}</h5>
                                <h6>Текст заявки: {{ $application->text }}</h6>
                                <h6>Предлагаемый балл: {{ $application->score }}</h6>
                                <p>Дата заявки: {{ $application->date }}</p>
                                @if (Route::has('route_missions_application'))
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                                <form method="post" action="/missions/application">
                                                    @csrf
                                                    <input type="hidden" value="{{ $application->id }}" name="application_id" id="application_id">
                                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                                    <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                                    <input type="hidden" value="{{ false }}" name="mxfault" id="mxfault">
                                                    <input type="hidden" value="{{ false }}" name="fault" id="fault">
                                                    <button type="submit" class="btn btn-danger w-100"><h6>Отклонить</h6></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-2"></div>
                @endforeach
                @break
            @case ("Принятые заявки проректором (подтверждено преподавателем)")
                @foreach($applications as $application)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Преподаватель: {{ $application->name }}</h5>
                                <h6>Текст заявки: {{ $application->text }}</h6>
                                <h6>Предлагаемый балл: {{ $application->score }}</h6>
                                <p>Дата заявки: {{ $application->date }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-2"></div>
                @endforeach
                @break
            @case ("Принятые заявки проректором (одобрено ректором)")
            @foreach($applications as $application)
                <div class="container bg-light rounded border border-primary">
                    <div class="row justify-content-center">
                        <div class="col text-center w-100 p-3 rounded border border-secondary">
                            <h5>Преподаватель: {{ $application->name }}</h5>
                            <h6>Текст заявки: {{ $application->text }}</h6>
                            <h6>Предлагаемый балл: {{ $application->score }}</h6>
                            <p>Дата заявки: {{ $application->date }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-2"></div>
            @endforeach
            @break
            @default
            @break
        @endswitch
    @endif
@endsection

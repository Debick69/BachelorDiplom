@extends('missions.missions')

@section('under-missions')
        @switch($applications_type)
            @case("Заявки на рассмотрении")
                @switch ($option)
                    @case(true)
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col text-center">
                                    @if (Route::has('route_missions_application_accept'))
                                        <h4>Предложите баллы:</h4>
                                        <form method="post" action="/missions/application/accept">
                                            @csrf
                                            @if($mxfault == true)
                                                <div class="container bg-warning text-white rounded">
                                                    <div class="row justify-content-center">
                                                        <div class="col text-center">
                                                            <p>Максимальное количество одобренных заданий</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <input class="w-100" type="number" step="0.01" name="score" id="score">
                                            @if($fault == true)
                                                <div class="container bg-warning text-white rounded">
                                                    <div class="row justify-content-center">
                                                        <div class="col text-center">
                                                            <p>Неверное значение балла</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="p-2"></div>
                                            <input type="hidden" value="{{ $application_id }}" name="application_id" id="application_id">
                                            <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                            <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                            <input type="hidden" value="{{ $option }}" name="option" id="option">
                                            <button type="submit" class="btn btn-success w-100"><h6>Отправить</h6></button>
                                        </form>
                                    <div class="p-2"></div>
                                    @endif
                                    @if (Route::has('route_missions_applications'))
                                        <form method="post" action="/missions/applications">
                                            @csrf
                                            <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                            <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                            <button type="submit" class="btn btn-danger w-100"><h6>Отмена</h6></button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @break
                    @case(false)
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col text-center">
                                    @if (Route::has('route_missions_application_reject'))
                                        <h4>Аргументируйте отказ:</h4>
                                        <form method="post" action="/missions/application/reject">
                                            @csrf
                                            <input class="w-100" type="text" name="answer" id="answer">
                                            @if($fault == true)
                                                <div class="container bg-warning text-white rounded">
                                                    <div class="row justify-content-center">
                                                        <div class="col text-center">
                                                            <p>Неверное значение ответа</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="p-2"></div>
                                            <input type="hidden" value="{{ $application_id }}" name="application_id" id="application_id">
                                            <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                            <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                            <input type="hidden" value="{{ $option }}" name="option" id="option">
                                            <button type="submit" class="btn btn-success w-100"><h6>Отправить</h6></button>
                                        </form>
                                        <div class="p-2"></div>
                                    @endif
                                    @if (Route::has('route_missions_applications'))
                                        <form method="post" action="/missions/applications">
                                            @csrf
                                            <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                            <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                            <button type="submit" class="btn btn-danger w-100"><h6>Отмена</h6></button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @break
                @endswitch
                @break
            @case ("Отклоненные заявки")
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col text-center">
                            @if (Route::has('route_missions_application_accept'))
                                <h4>Предложите баллы:</h4>
                                <form method="post" action="/missions/application/accept">
                                    @csrf
                                    @if($mxfault == true)
                                        <div class="container bg-warning text-white rounded">
                                            <div class="row justify-content-center">
                                                <div class="col text-center">
                                                    <p>Максимальное количество одобренных заданий</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <input class="w-100" type="number" step="0.01" name="score" id="score">
                                    @if($fault == true)
                                        <div class="container bg-warning text-white rounded">
                                            <div class="row justify-content-center">
                                                <div class="col text-center">
                                                    <p>Неверный значение балла</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="p-2"></div>
                                    <input type="hidden" value="{{ $application_id }}" name="application_id" id="application_id">
                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                    <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                    <input type="hidden" value="{{ $option }}" name="option" id="option">
                                    <button type="submit" class="btn btn-success w-100"><h6>Отправить</h6></button>
                                </form>
                                <div class="p-2"></div>
                            @endif
                            @if (Route::has('route_missions_applications'))
                                <form method="post" action="/missions/applications">
                                    @csrf
                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                    <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                    <button type="submit" class="btn btn-danger w-100"><h6>Отмена</h6></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @break
            @case ("Принятые заявки проректором (ожидание подтверждения от преподавателя)")
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col text-center">
                            @if (Route::has('route_missions_application_reject'))
                                <h4>Аргументируйте отказ:</h4>
                                <form method="post" action="/missions/application/reject">
                                    @csrf
                                    <input class="w-100" type="text" name="answer" id="answer">
                                    @if($fault == true)
                                        <div class="container bg-warning text-white rounded">
                                            <div class="row justify-content-center">
                                                <div class="col text-center">
                                                    <p>Неверное значение ответа</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="p-2"></div>
                                    <input type="hidden" value="{{ $application_id }}" name="application_id" id="application_id">
                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                    <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                    <input type="hidden" value="{{ $option }}" name="option" id="option">
                                    <button type="submit" class="btn btn-success w-100"><h6>Отправить</h6></button>
                                </form>
                                <div class="p-2"></div>
                            @endif
                            @if (Route::has('route_missions_applications'))
                                <form method="post" action="/missions/applications">
                                    @csrf
                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                    <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                    <button type="submit" class="btn btn-danger w-100"><h6>Отмена</h6></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @break
            @default
                @break
        @endswitch
@endsection

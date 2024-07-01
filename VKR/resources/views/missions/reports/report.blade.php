@extends('missions.missions')

@section('under-missions')
        @switch($reports_type)
            @case("Отчеты на рассмотрении")
                @switch ($option)
                    @case(true)
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col text-center">
                                    @if (Route::has('route_missions_report_accept'))
                                        <h4>Оценка:</h4>
                                        <form method="post" action="/missions/report/accept">
                                            @csrf
                                            <input class="w-100" type="number" name="rating" id="rating">
                                            @if($fault == true)
                                                <div class="container bg-warning text-white rounded">
                                                    <div class="row justify-content-center">
                                                        <div class="col text-center">
                                                            <p>Неверное значение оценки</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="p-2"></div>
                                            <input type="hidden" value="{{ $report_id }}" name="report_id" id="report_id">
                                            <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                            <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                                            <input type="hidden" value="{{ $option }}" name="option" id="option">
                                            <button type="submit" class="btn btn-success w-100">Отправить</button>
                                        </form>
                                    <div class="p-2"></div>
                                    @endif
                                    @if (Route::has('route_missions_reports'))
                                        <form method="post" action="/missions/reports">
                                            @csrf
                                            <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                            <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                                            <button type="submit" class="btn btn-danger w-100">Отмена</button>
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
                                    @if (Route::has('route_missions_report_reject'))
                                        <h4>Аргументируйте отказ:</h4>
                                        <form method="post" action="/missions/report/reject">
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
                                            <input type="hidden" value="{{ $report_id }}" name="report_id" id="report_id">
                                            <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                            <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                                            <input type="hidden" value="{{ $option }}" name="option" id="option">
                                            <button type="submit" class="btn btn-success w-100">Отправить</button>
                                        </form>
                                        <div class="p-2"></div>
                                    @endif
                                    @if (Route::has('route_missions_reports'))
                                        <form method="post" action="/missions/reports">
                                            @csrf
                                            <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                            <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                                            <button type="submit" class="btn btn-danger w-100">Отмена</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @break
                @endswitch
                @break
            @case ("Отклоненные отчеты")
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col text-center">
                            @if (Route::has('route_missions_report_accept'))
                                <h4>Оценка:</h4>
                                <form method="post" action="/missions/report/accept">
                                    @csrf
                                    <input class="w-100" type="number" name="rating" id="rating">
                                    @if($fault == true)
                                        <div class="container bg-warning text-white rounded">
                                            <div class="row justify-content-center">
                                                <div class="col text-center">
                                                    <p>Неверное значение оценки</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="p-2"></div>
                                    <input type="hidden" value="{{ $report_id }}" name="report_id" id="report_id">
                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                    <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                                    <input type="hidden" value="{{ $option }}" name="option" id="option">
                                    <button type="submit" class="btn btn-success w-100">Отправить</button>
                                </form>
                                <div class="p-2"></div>
                            @endif
                            @if (Route::has('route_missions_reports'))
                                <form method="post" action="/missions/reports">
                                    @csrf
                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                    <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                                    <button type="submit" class="btn btn-danger w-100">Отмена</button>
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

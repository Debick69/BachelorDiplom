@extends('missions.missions')

@section('under-missions')
    <div class="container">
        <div class="row">
            @if (Route::has('route_missions_reports'))
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/reports">
                        @csrf
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{"Отчеты на рассмотрении"}}" name="reports_type" id="reports_type">
                        <button type="submit" class="btn btn-success h-100 w-100">Отчеты на рассмотрении</button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/reports">
                        @csrf
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{"Отклоненные отчеты"}}" name="reports_type" id="reports_type">
                        <button type="submit" class="btn btn-success h-100 w-100">Отклоненные отчеты</button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/reports">
                        @csrf
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{"Принятые отчеты"}}" name="reports_type" id="reports_type">
                        <button type="submit" class="btn btn-success h-100 w-100">Принятые отчеты</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    <h4 class="text-center">{{ $reports_type }}:</h4>
    @if($reports == null)
        <h5 class="text-center">{{ $reports_type }} отсутствуют!</h5>
    @else
        @switch($reports_type)
            @case("Отчеты на рассмотрении")
                @foreach($reports as $report)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Преподаватель: {{ $report->name }}</h5>
                                <h6>Текст отчета: {{ $report->text }}</h6>
                                <p>Дата отчета: {{ $report->date }}</p>
                                @if (Route::has('route_missions_report'))
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                                <form method="post" action="/missions/report">
                                                    @csrf
                                                    <input type="hidden" value="{{ $report->id }}" name="report_id" id="report_id">
                                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                                    <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                                                    <input type="hidden" value="{{ false }}" name="fault" id="fault">
                                                    <input type="hidden" value="{{ true }}" name="option" id="option">
                                                    <button type="submit" class="btn btn-success w-100"><h6>Принять</h6></button>
                                                </form>
                                            </div>
                                            <div class="col-sm">
                                                <form method="post" action="/missions/report">
                                                    @csrf
                                                    <input type="hidden" value="{{ $report->id }}" name="report_id" id="report_id">
                                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                                    <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                                                    <input type="hidden" value="{{ false }}" name="fault" id="fault">
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
            @case ("Отклоненные отчеты")
                @foreach($reports as $report)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Преподаватель: {{ $report->name }}</h5>
                                <h6>Текст отчета: {{ $report->text }}</h6>
                                <h6>Ответ на отчет: {{ $report->answer_text }}</h6>
                                <p>Дата отчета: {{ $report->date }}</p>
                                @if (Route::has('route_missions_report'))
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                                <form method="post" action="/missions/report">
                                                    @csrf
                                                    <input type="hidden" value="{{ $report->id }}" name="report_id" id="report_id">
                                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                                    <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
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
            @case ("Принятые отчеты")
                @foreach($reports as $report)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Преподаватель: {{ $report->name }}</h5>
                                <h6>Текст отчета: {{ $report->text }}</h6>
                                <h6>Оценка: {{ $report->rating }}</h6>
                                <p>Дата отчета: {{ $report->date }}</p>
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

@extends('missions.missions')

@section('under-missions')
    <div class="container">
        <div class="row">
            @if (Route::has('route_missions_missions_reports_teacher_mine_post'))
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_reports_teacher_mine_post">
                        @csrf
                        <input type="hidden" value="{{"Не выложенные отчеты"}}" name="reports_type" id="reports_type">
                        <button type="submit" class="btn btn-success h-100 w-100">Не выложенные отчеты</button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_reports_teacher_mine_post">
                        @csrf
                        <input type="hidden" value="{{"Отчеты на рассмотрении"}}" name="reports_type" id="reports_type">
                        <button type="submit" class="btn btn-success h-100 w-100">Отчеты на рассмотрении</button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_reports_teacher_mine_post">
                        @csrf
                        <input type="hidden" value="{{"Отклоненные отчеты"}}" name="reports_type" id="reports_type">
                        <button type="submit" class="btn btn-success h-100 w-100">Отклоненные отчеты</button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_reports_teacher_mine_post">
                        @csrf
                        <input type="hidden" value="{{"Принятые отчеты"}}" name="reports_type" id="reports_type">
                        <button type="submit" class="btn btn-success h-100 w-100">Принятые отчеты</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    <h4 class="text-center">{{$reports_type}}:</h4>
    @if($missions_reports == null)
        <h5 class="text-center">{{ $reports_type }} отсутствуют!</h5>
    @else
        @switch($reports_type)
            @case("Не выложенные отчеты")
                @foreach($missions_reports as $report)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Название: {{ $report->name }}</h5>
                                <h6>Описание: {{ $report->missions_text }}</h6>
                                <h6>Проректор: {{ $report->name_vice_rector }}</h6>
                                <p>Дата начала аттестации: {{ $report->date_start_attestation }}</p>
                                <p>Дата окончания аттестации: {{ $report->date_end_attestation }}</p>
                                @if (Route::has('route_missions_missions_reports_teacher_mine_rework'))
                                    <form method="post" action="/missions/missions_reports_teacher_mine/rework">
                                        @csrf
                                        <input type="hidden" value="{{ $report->id }}" name="report_id" id="report_id">
                                        <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                                        <input type="hidden" value="{{ $report->mission_id }}" name="mission_id" id="mission_id">
                                        <input type="hidden" value="{{ false }}" name="fault" id="fault">
                                        <button type="submit" class="btn btn-success w-100">Выложить отчет</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-2"></div>
                @endforeach
                @break
            @case("Отчеты на рассмотрении")
            @foreach($missions_reports as $report)
                <div class="container bg-light rounded border border-primary">
                    <div class="row justify-content-center">
                        <div class="col text-center w-100 p-3 rounded border border-secondary">
                            <h5>Название: {{ $report->name }}</h5>
                            <h6>Описание: {{ $report->missions_text }}</h6>
                            <h6>Текст отчета: {{ $report->text }}</h6>
                            <h6>Проректор: {{ $report->name_vice_rector }}</h6>
                            <p>Дата начала аттестации: {{ $report->date_start_attestation }}</p>
                            <p>Дата окончания аттестации: {{ $report->date_end_attestation }}</p>
                            @if (Route::has('route_missions_missions_reports_teacher_mine_rework'))
                                <form method="post" action="/missions/missions_reports_teacher_mine/rework">
                                    @csrf
                                    <input type="hidden" value="{{ $report->id }}" name="report_id" id="report_id">
                                    <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                                    <input type="hidden" value="{{ $report->mission_id }}" name="mission_id" id="mission_id">
                                    <button type="submit" class="btn btn-danger w-100">Отклонить отчет</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-2"></div>
            @endforeach
            @break
            @case("Отклоненные отчеты")
            @foreach($missions_reports as $report)
                <div class="container bg-light rounded border border-primary">
                    <div class="row justify-content-center">
                        <div class="col text-center w-100 p-3 rounded border border-secondary">
                            <h5>Название: {{ $report->name }}</h5>
                            <h6>Описание: {{ $report->missions_text }}</h6>
                            <h6>Текст отчета: {{ $report->text }}</h6>
                            <h6>Ответ на отчет: {{ $report->answer_text }}</h6>
                            <h6>Проректор: {{ $report->name_vice_rector }}</h6>
                            <p>Дата начала аттестации: {{ $report->date_start_attestation }}</p>
                            <p>Дата окончания аттестации: {{ $report->date_end_attestation }}</p>
                            @if (Route::has('route_missions_missions_reports_teacher_mine_rework'))
                                <form method="post" action="/missions/missions_reports_teacher_mine/rework">
                                    @csrf
                                    <input type="hidden" value="{{ $report->id }}" name="report_id" id="report_id">
                                    <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                                    <input type="hidden" value="{{ $report->mission_id }}" name="mission_id" id="mission_id">
                                    <input type="hidden" value="{{ false }}" name="fault" id="fault">
                                    <button type="submit" class="btn btn-success w-100">Отправить повторно</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-2"></div>
            @endforeach
            @break
            @case("Принятые отчеты")
            @foreach($missions_reports as $report)
                <div class="container bg-light rounded border border-primary">
                    <div class="row justify-content-center">
                        <div class="col text-center w-100 p-3 rounded border border-secondary">
                            <h5>Название: {{ $report->name }}</h5>
                            <h6>Описание: {{ $report->missions_text }}</h6>
                            <h6>Оценка: {{ $report->rating }}</h6>
                            <h6>Текст отчета: {{ $report->text }}</h6>
                            <h6>Проректор: {{ $report->name_vice_rector }}</h6>
                            <p>Дата начала аттестации: {{ $report->date_start_attestation }}</p>
                            <p>Дата окончания аттестации: {{ $report->date_end_attestation }}</p>
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

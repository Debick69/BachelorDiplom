@extends('missions.missions')

@section('under-missions')
    <div class="container bg-light rounded border border-primary">
        <div class="row justify-content-center">
            <div class="col text-center w-100 p-3 rounded border border-secondary">
                @if (Route::has('route_missions_reports_teacher_mine_accept'))
                    <form method="post" action="/missions/reports_teacher_mine/accept">
                        @csrf
                        <h5 class="text-success">Текст отчета:</h5>
                        <input class="w-100" type="text" name="reports_teacher_text" id="reports_teacher_text">
                        @if($fault == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Нет текста отчета</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <input class="w-100" type="hidden" value="{{ $report_id }}" name="report_id" id="report_id">
                        <input class="w-100" type="hidden" value="{{ $mission->id }}" name="mission_id" id="mission_id">
                        <input class="w-100" type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                        <div class="p-2"></div>
                        <button type="submit" class="btn btn-success w-100">Отправить</button>
                    </form>
                @endif
                <div class="p-2"></div>
                    @if (Route::has('route_missions_missions_reports_teacher_mine_post'))
                        <div class="col-sm">
                            <form class="h-100" method="post" action="/missions/missions_reports_teacher_mine_post">
                                @csrf
                                <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                                <button type="submit" class="btn btn-success h-100 w-100">Вернуться</button>
                            </form>
                        </div>
                    @endif
            </div>
        </div>
    </div>
@endsection

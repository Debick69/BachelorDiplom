@extends('missions.missions')

@section('under-missions')
    <div class="container bg-light rounded border border-primary">
        <div class="row justify-content-center">
            <div class="col text-center w-100 p-3 rounded border border-secondary">
                @if (Route::has('route_missions_applications_teacher_mine_accept'))
                    <form method="post" action="/missions/applications_teacher_mine/accept">
                        @csrf
                        <h5>Название:</h5>
                        <input class="w-100" type="text" value="{{ $mission->name }}" name="mission_name" id="mission_name" readonly>
                        <h5>Максимальный возможный балл:</h5>
                        <input class="w-100" type="number" step="0.01" value="{{ $mission->max_score }}" name="mission_max_score" id="mission_max_score" readonly>
                        <h5>Описание:</h5>
                        <input class="w-100" type="text" value="{{ $mission->text }}" name="mission_text" id="mission_text" readonly>
                        <h5>Максимальное количество мест:</h5>
                        <input class="w-100" type="number" value="{{ $mission->max_workers }}" name="mission_max_workers" id="mission_max_workers" readonly>
                        <h5>Дата создания:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_start)[0] }}T{{explode(" ", $mission->date_start)[1]}}" name="mission_date_start" id="mission_date_start" readonly>
                        <h5>Дата начала приема заявок:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_start_application)[0] }}T{{explode(" ", $mission->date_start_application)[1]}}" name="mission_date_start_application" id="mission_date_start_application" readonly>
                        <h5>Дата окончания приема заявок:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_end_application)[0] }}T{{explode(" ", $mission->date_end_application)[1]}}" name="mission_date_end_application" id="mission_date_end_application" readonly>
                        <h5>Дата начала работы:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_start_mission)[0] }}T{{explode(" ", $mission->date_start_mission)[1]}}" name="mission_date_start_mission" id="mission_date_start_mission" readonly>
                        <h5>Дата окончания работы:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_end_mission)[0] }}T{{explode(" ", $mission->date_end_mission)[1]}}" name="mission_date_end_mission" id="mission_date_end_mission" readonly>
                        <h5>Дата начала аттестации:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_start_attestation)[0] }}T{{explode(" ", $mission->date_start_attestation)[1]}}" name="mission_date_start_attestation" id="mission_date_start_attestation" readonly>
                        <h5>Дата окончания аттестации:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_end_attestation)[0] }}T{{explode(" ", $mission->date_end_attestation)[1]}}" name="mission_date_end_attestation" id="mission_date_end_attestation" readonly>
                        <h5>Дата окончания:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_end)[0] }}T{{explode(" ", $mission->date_end)[1]}}" name="mission_date_end" id="mission_date_end" readonly>
                        <h5 class="text-success">Текст заявки:</h5>
                        <input class="w-100" type="text" name="applications_teacher_text" id="applications_teacher_text">
                        @if($fault == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Нет текста заявки</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <input class="w-100" type="hidden" value="{{ $application_id }}" name="application_id" id="application_id">
                        <input class="w-100" type="hidden" value="{{ $mission->id }}" name="mission_id" id="mission_id">
                        <input class="w-100" type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                        <div class="p-2"></div>
                        <button type="submit" class="btn btn-success w-100">Отправить</button>
                    </form>
                @endif
                <div class="p-2"></div>
                    @if (Route::has('route_missions_missions_applications_teacher_mine_post'))
                        <div class="col-sm">
                            <form class="h-100" method="post" action="/missions/missions_applications_teacher_mine_post">
                                @csrf
                                <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                <button type="submit" class="btn btn-danger h-100 w-100">Отмена</button>
                            </form>
                        </div>
                    @endif
            </div>
        </div>
    </div>
@endsection

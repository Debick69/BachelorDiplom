@extends('missions.missions')

@section('under-missions')
    <div class="container bg-light rounded border border-primary">
        <div class="row justify-content-center">
            <div class="col text-center w-100 p-3 rounded border border-secondary">
                @if (Route::has('route_missions_create_create'))
                    <form method="post" action="/missions/create/create">
                        @csrf
                        <h5 class="text-success">Название:</h5>
                        <input class="w-100" type="text" value="{{ $mission->name }}" name="mission_name" id="mission_name">
                        @if($fault_name == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Пустое название</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h5 class="text-success">Максимальный возможный балл:</h5>
                        <input class="w-100" type="number" step="0.01" value="{{ $mission->max_score }}" name="mission_max_score" id="mission_max_score">
                        @if($fault_max_score == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Неверное значение балла</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h5 class="text-success">Описание:</h5>
                        <input class="w-100" type="text" value="{{ $mission->text }}" name="mission_text" id="mission_text">
                        @if($fault_text == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Пустое описание</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h5 class="text-success">Максимальное количество мест:</h5>
                        <input class="w-100" type="number" value="{{ $mission->max_workers }}" name="mission_max_workers" id="mission_max_workers">
                        @if($fault_max_workers == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Неверное значение количества мест</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h5 class="text-success">Дата начала приема заявок:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_start_application)[0] }}T{{explode(" ", $mission->date_start_application)[1]}}" name="mission_date_start_application" id="mission_date_start_application">
                        @if($faults_date["fault_date_start_application"] == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Неверное значение даты начала приема заявок</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h5 class="text-success">Дата окончания приема заявок:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_end_application)[0] }}T{{explode(" ", $mission->date_end_application)[1]}}" name="mission_date_end_application" id="mission_date_end_application">
                        @if($faults_date["fault_date_end_application"] == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Неверное значение даты окончания приема заявок</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h5 class="text-success">Дата начала выполнения работы:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_start_mission)[0] }}T{{explode(" ", $mission->date_start_mission)[1]}}" name="mission_date_start_mission" id="mission_date_start_mission">
                        @if($faults_date["fault_date_start_mission"] == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Неверное значение даты начала выполнения работы</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h5 class="text-success">Дата окончания выполнения работы:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_end_mission)[0] }}T{{explode(" ", $mission->date_end_mission)[1]}}" name="mission_date_end_mission" id="mission_date_end_mission">
                        @if($faults_date["fault_date_end_mission"] == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Неверное значение даты окончания выполнения работы</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h5 class="text-success">Дата начала аттестации:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_start_attestation)[0] }}T{{explode(" ", $mission->date_start_attestation)[1]}}" name="mission_date_start_attestation" id="mission_date_start_attestation">
                        @if($faults_date["fault_date_start_attestation"] == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Неверное значение даты начала аттестации</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h5 class="text-success">Дата окончания аттестации:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_end_attestation)[0] }}T{{explode(" ", $mission->date_end_attestation)[1]}}" name="mission_date_end_attestation" id="mission_date_end_attestation">
                        @if($faults_date["fault_date_end_attestation"] == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Неверное значение даты окончания аттестации</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <h5 class="text-success">Дата окончания индивидуального задания:</h5>
                        <input class="w-100" type="datetime-local" value="{{explode(" ", $mission->date_end)[0] }}T{{explode(" ", $mission->date_end)[1]}}" name="mission_date_end" id="mission_date_end">
                        @if($faults_date["fault_date_end"] == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Неверное значение даты окончания индивидуального задания</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="p-2"></div>
                        <button type="submit" class="btn btn-success w-100"><h6>Создать</h6></button>
                    </form>
                @endif
                <div class="p-2"></div>
            </div>
        </div>
    </div>
@endsection

@extends('missions.missions')

@section('under-missions')
    <div class="container">
        <div class="row">
            @if (Route::has('route_missions_missions_applications_teacher_mine_post'))
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_applications_teacher_mine_post">
                        @csrf
                        <input type="hidden" value="{{"Заявки на рассмотрении"}}" name="applications_type" id="applications_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Заявки на рассмотрении</h4></button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_applications_teacher_mine_post">
                        @csrf
                        <input type="hidden" value="{{"Отклоненные заявки"}}" name="applications_type" id="applications_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Отклоненные заявки</h4></button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_applications_teacher_mine_post">
                        @csrf
                        <input type="hidden" value="{{"Принятые заявки проректором (ожидание подтверждения от преподавателя)"}}" name="applications_type" id="applications_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Принятые заявки проректором (ожидание подтверждения от преподавателя)</h4></button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_applications_teacher_mine_post">
                        @csrf
                        <input type="hidden" value="{{"Принятые заявки проректором (подтверждено преподавателем)"}}" name="applications_type" id="applications_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Принятые заявки проректором (подтверждено преподавателем)</h4></button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_applications_teacher_mine_post">
                        @csrf
                        <input type="hidden" value="{{"Принятые заявки проректором (одобрено ректором)"}}" name="applications_type" id="applications_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Принятые заявки проректором (одобрено ректором)</h4></button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    <h4 class="text-center">{{$applications_type}}:</h4>
    @if($missions_applications == null)
        <h5 class="text-center">{{ $applications_type }} отсутствуют!</h5>
    @else
        @switch($applications_type)
            @case("Заявки на рассмотрении")
                @foreach($missions_applications as $application)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Название: {{ $application->name }}</h5>
                                <h6>Описание: {{ $application->missions_text }}</h6>
                                <h6>Проректор: {{ $application->name_vice_rector }}</h6>
                                <h6>Максимальный возможный балл: {{ $application->max_score }}</h6>
                                <h6>Текст заявки: {{ $application->text }}</h6>
                                <p>Дата начала приема заявок: {{ $application->date_start_application }}</p>
                                <p>Дата окончания приема заявок: {{ $application->date_end_application }}</p>
                                @if (Route::has('route_missions_missions_applications_teacher_mine_rework'))
                                    <form method="post" action="/missions/missions_applications_teacher_mine/rework">
                                        @csrf
                                        <input type="hidden" value="{{ $application->id }}" name="application_id" id="application_id">
                                        <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                        <input type="hidden" value="{{ $application->mission_id }}" name="mission_id" id="mission_id">
                                        <button type="submit" class="btn btn-danger w-100"><h6>Отклонить заявку</h6></button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-2"></div>
                @endforeach
                @break
            @case("Отклоненные заявки")
            @foreach($missions_applications as $application)
                <div class="container bg-light rounded border border-primary">
                    <div class="row justify-content-center">
                        <div class="col text-center w-100 p-3 rounded border border-secondary">
                            <h5>Название: {{ $application->name }}</h5>
                            <h6>Описание: {{ $application->missions_text }}</h6>
                            <h6>Проректор: {{ $application->name_vice_rector }}</h6>
                            <h6>Максимальный возможный балл: {{ $application->max_score }}</h6>
                            <h6>Текст заявки: {{ $application->text }}</h6>
                            <h6>Ответ на заявку: {{ $application->answer_text }}</h6>
                            <p>Дата начала приема заявок: {{ $application->date_start_application }}</p>
                            <p>Дата окончания приема заявок: {{ $application->date_end_application }}</p>
                            @if (Route::has('route_missions_missions_applications_teacher_mine_rework'))
                                <form method="post" action="/missions/missions_applications_teacher_mine/rework">
                                    @csrf
                                    <input type="hidden" value="{{ $application->id }}" name="application_id" id="application_id">
                                    <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                    <input type="hidden" value="{{ $application->mission_id }}" name="mission_id" id="mission_id">
                                    <input type="hidden" value="{{ false }}" name="fault" id="fault">
                                    <button type="submit" class="btn btn-success w-100"><h6>Отправить повторно</h6></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-2"></div>
            @endforeach
            @break
            @case("Принятые заявки проректором (ожидание подтверждения от преподавателя)")
            @foreach($missions_applications as $application)
                <div class="container bg-light rounded border border-primary">
                    <div class="row justify-content-center">
                        <div class="col text-center w-100 p-3 rounded border border-secondary">
                            <h5>Название: {{ $application->name }}</h5>
                            <h6>Описание: {{ $application->missions_text }}</h6>
                            <h6>Проректор: {{ $application->name_vice_rector }}</h6>
                            <h6>Максимальный возможный балл: {{ $application->max_score }}</h6>
                            <h6>Текст заявки: {{ $application->text }}</h6>
                            <h6>Предлогаемый балл: {{ $application->score }}</h6>
                            <p>Дата начала приема заявок: {{ $application->date_start_application }}</p>
                            <p>Дата окончания приема заявок: {{ $application->date_end_application }}</p>
                            @if (Route::has('route_missions_missions_applications_teacher_mine_rework'))
                                <form method="post" action="/missions/missions_applications_teacher_mine/rework">
                                    @csrf
                                    <input type="hidden" value="{{ $application->id }}" name="application_id" id="application_id">
                                    <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                    <input type="hidden" value="{{ $application->mission_id }}" name="mission_id" id="mission_id">
                                    <input type="hidden" value="{{ true }}" name="option" id="option">
                                    <button type="submit" class="btn btn-success w-100"><h6>Согласиться</h6></button>
                                </form>
                                <div class="p-2"></div>
                                <form method="post" action="/missions/missions_applications_teacher_mine/rework">
                                    @csrf
                                    <input type="hidden" value="{{ $application->id }}" name="application_id" id="application_id">
                                    <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                    <input type="hidden" value="{{ $application->mission_id }}" name="mission_id" id="mission_id">
                                    <input type="hidden" value="{{ false }}" name="option" id="option">
                                    <button type="submit" class="btn btn-danger w-100"><h6>Отказаться</h6></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-2"></div>
            @endforeach
            @break
            @case("Принятые заявки проректором (подтверждено преподавателем)")
            @foreach($missions_applications as $application)
                <div class="container bg-light rounded border border-primary">
                    <div class="row justify-content-center">
                        <div class="col text-center w-100 p-3 rounded border border-secondary">
                            <h5>Название: {{ $application->name }}</h5>
                            <h6>Описание: {{ $application->missions_text }}</h6>
                            <h6>Проректор: {{ $application->name_vice_rector }}</h6>
                            <h6>Максимальный возможный балл: {{ $application->max_score }}</h6>
                            <h6>Текст заявки: {{ $application->text }}</h6>
                            <h6>Предлогаемый балл: {{ $application->score }}</h6>
                            <p>Дата начала приема заявок: {{ $application->date_start_application }}</p>
                            <p>Дата окончания приема заявок: {{ $application->date_end_application }}</p>
                            @if (Route::has('route_missions_missions_applications_teacher_mine_rework'))
                                <form method="post" action="/missions/missions_applications_teacher_mine/rework">
                                    @csrf
                                    <input type="hidden" value="{{ $application->id }}" name="application_id" id="application_id">
                                    <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                                    <input type="hidden" value="{{ $application->mission_id }}" name="mission_id" id="mission_id">
                                    <button type="submit" class="btn btn-danger w-100"><h6>Отказаться</h6></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="p-2"></div>
            @endforeach
            @break
            @case("Принятые заявки проректором (одобрено ректором)")
            @foreach($missions_applications as $application)
                <div class="container bg-light rounded border border-primary">
                    <div class="row justify-content-center">
                        <div class="col text-center w-100 p-3 rounded border border-secondary">
                            <h5>Название: {{ $application->name }}</h5>
                            <h6>Описание: {{ $application->missions_text }}</h6>
                            <h6>Проректор: {{ $application->name_vice_rector }}</h6>
                            <h6>Максимальный возможный балл: {{ $application->max_score }}</h6>
                            <h6>Текст заявки: {{ $application->text }}</h6>
                            <h6>Предлогаемый балл: {{ $application->score }}</h6>
                            <p>Дата начала приема заявок: {{ $application->date_start_application }}</p>
                            <p>Дата окончания приема заявок: {{ $application->date_end_application }}</p>
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

@extends('missions.missions')

@section('under-missions')
    <h4 class="text-center">Выберите индивидуальное задание:</h4>
    @if($missions_approve == null)
        <h5 class="text-center">Индивидуальных заданий для итогового утверждения нет!</h5>
    @else
        @foreach($missions_approve as $mission)
            <div class="container bg-light rounded border border-primary">
                <div class="row justify-content-center">
                    <div class="col text-center w-100 p-3 rounded border border-secondary">
                        <h5>Название: {{ $mission->name }}</h5>
                        <h6>Описание: {{ $mission->text }}</h6>
                        <h6>Проректор задания: {{ $mission->name_vice_rector }}</h6>
                        <h6>Максимальный возможный балл: {{ $mission->max_score }}</h6>
                        <p>Количество мест всего: {{ $mission->max_workers }}</p>
                        <p>Количество занятых мест: {{ $mission->answer_count }}</p>
                        <p>Количество новых заявок ожидающих утверждения: {{ $mission->applications_count }}</p>
                        <p>Дата начала приема заявок: {{ $mission->date_start_application }}</p>
                        @if (Route::has('route_missions_approve'))
                            <form method="post" action="/missions/approve">
                                @csrf
                                <input type="hidden" value="{{ $mission->id }}" name="mission_id" id="mission_id">
                                <input type="hidden" value="{{ "Принятые заявки проректором (подтверждено преподавателем)" }}" name="approve_type" id="approve_type">
                                <button type="submit" class="btn btn-success w-100">Открыть</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="p-2"></div>
        @endforeach
    @endif
@endsection

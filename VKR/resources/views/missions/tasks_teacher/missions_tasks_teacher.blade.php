@extends('missions.missions')

@section('under-missions')
    <h4 class="text-center">Выберите индивидуальное задание:</h4>
    @if($missions_tasks_teacher == null)
        <h5 class="text-center">Индивидуальных заданий на выполнении нет!</h5>
    @else
        @foreach($missions_tasks_teacher as $mission)
            <div class="container bg-light rounded border border-primary">
                <div class="row justify-content-center">
                    <div class="col text-center w-100 p-3 rounded border border-secondary">
                        <h5>Название: {{ $mission->name }}</h5>
                        <h6>Описание: {{ $mission->text }}</h6>
                        <h6>Максимальный возможный балл: {{ $mission->max_score }}</h6>
                        <h6>Предложенный балл: {{ $mission->application_score }}</h6>
                        <p>Дата начала выполнения задания: {{ $mission->date_start_mission }}</p>
                        @if (Route::has('route_missions_tasks_teacher'))
                            <form method="post" action="/missions/tasks_teacher">
                                @csrf
                                <input type="hidden" value="{{ $mission->id }}" name="mission_id" id="mission_id">
                                <button type="submit" class="btn btn-success w-100"><h6>Открыть</h6></button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="p-2"></div>
        @endforeach
    @endif
@endsection

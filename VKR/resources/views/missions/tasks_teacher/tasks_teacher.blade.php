@extends('missions.missions')

@section('under-missions')
    <div class="container bg-light rounded border border-primary">
        <div class="row justify-content-center">
            <div class="col text-center w-100 p-3 rounded border border-secondary">
                <form>
                    @csrf
                    <h5>Название:</h5>
                    <p>{{ $mission->name }}</p>
                    <h5>Максимальный возможный балл:</h5>
                    <p>{{ $mission->max_score }}</p>
                    <h5>Описание:</h5>
                    <p>{{ $mission->text }}</p>
                    <h5>Предложенный балл:</h5>
                    <p>{{ $mission->application_score }}</p>
                    <h5>Дата начала работы:</h5>
                    <p>{{ $mission->date_start_mission }}</p>
                    <h5>Дата окончания работы:</h5>
                    <p>{{ $mission->date_end_mission }}</p>
                </form>
                <div class="p-2"></div>
                @if (Route::has('route_missions_missions_tasks_teacher'))
                    <div class="col-sm">
                        <form method="get" action="/missions/missions_tasks_teacher">
                            @csrf
                            <button type="submit" class="btn btn-success w-100"><h6>Вернуться</h6></button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

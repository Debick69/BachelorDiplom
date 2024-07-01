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
                    <h5>Дата начала работы:</h5>
                    <p>{{ $mission->date_start_mission }}</p>
                    <h5>Дата окончания работы:</h5>
                    <p>{{ $mission->date_end_mission }}</p>
                </form>
                <h5>Список преподавателей:</h5>
                @foreach($users as $user)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h6>Имя преподавателя: {{ $user->user_name }}</h6>
                                <p>Предложенный балл: {{ $user->application_score }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-2"></div>
                @endforeach
                <div class="p-2"></div>
                @if (Route::has('route_missions_missions_tasks'))
                    <div class="col-sm">
                        <form method="get" action="/missions/missions_tasks">
                            @csrf
                            <button type="submit" class="btn btn-success w-100"><h6>Вернуться</h6></button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@extends('missions.missions')

@section('under-missions')
    <div class="container">
        <div class="row">
            @if (Route::has('route_missions_approve'))
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/approve">
                        @csrf
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{"Принятые заявки проректором (подтверждено преподавателем)"}}" name="approve_type" id="approve_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Принятые заявки проректором (подтверждено преподавателем)</h4></button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/approve">
                        @csrf
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{"Принятые заявки проректором (одобрено ректором)"}}" name="approve_type" id="approve_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Принятые заявки проректором (одобрено ректором)</h4></button>
                    </form>
                </div>
            @endif
        </div>
    </div>
    <h4 class="text-center">{{ $approve_type }}:</h4>
    @if($approve == null)
        <h5 class="text-center">{{ $approve_type }} отсутствуют!</h5>
    @else
        @switch($approve_type)
            @case("Принятые заявки проректором (подтверждено преподавателем)")
                @foreach($approve as $approv)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Преподаватель: {{ $approv->name }}</h5>
                                <h6>Текст заявки: {{ $approv->text }}</h6>
                                <h6>Предлагаемый балл: {{ $approv->score }}</h6>
                                <p>Дата заявки: {{ $approv->date }}</p>
                                @if (Route::has('route_missions_approv'))
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm">
                                                <form method="post" action="/missions/approv">
                                                    @csrf
                                                    <input type="hidden" value="{{ $approv->id }}" name="approv_id" id="approv_id">
                                                    <input type="hidden" value="{{ $approv->user_id }}" name="user_id" id="user_id">
                                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                                    <input type="hidden" value="{{ $approve_type }}" name="approve_type" id="approve_type">
                                                    <input type="hidden" value="{{ false }}" name="fault" id="fault">
                                                    <input type="hidden" value="{{ true }}" name="option" id="option">
                                                    <button type="submit" class="btn btn-success w-100"><h6>Принять</h6></button>
                                                </form>
                                            </div>
                                            <div class="col-sm">
                                                <form method="post" action="/missions/approv">
                                                    @csrf
                                                    <input type="hidden" value="{{ $approv->id }}" name="approv_id" id="approv_id">
                                                    <input type="hidden" value="{{ $approv->user_id }}" name="user_id" id="user_id">
                                                    <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                                                    <input type="hidden" value="{{ $approve_type }}" name="approve_type" id="approve_type">
                                                    <input type="hidden" value="{{ false }}" name="fault" id="fault">
                                                    <input type="hidden" value="{{ false }}" name="option" id="option">
                                                    <button type="submit" class="btn btn-danger w-100"><h6>Отказать</h6></button>
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
            @case ("Принятые заявки проректором (одобрено ректором)")
            @foreach($approve as $approv)
                <div class="container bg-light rounded border border-primary">
                    <div class="row justify-content-center">
                        <div class="col text-center w-100 p-3 rounded border border-secondary">
                            <h5>Преподаватель: {{ $approv->name }}</h5>
                            <h6>Текст заявки: {{ $approv->text }}</h6>
                            <h6>Предлагаемый балл: {{ $approv->score }}</h6>
                            <p>Дата заявки: {{ $approv->date }}</p>
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

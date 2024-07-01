@extends('missions.missions')

@section('under-missions')
    <div class="container">
        <div class="row">
            @if (Route::has('route_missions_missions_edit_post'))
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_edit_post">
                        @csrf
                        <input type="hidden" value="{{"Не выложенные задания"}}" name="edit_type" id="edit_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Не выложенные задания</h4></button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_edit_post">
                        @csrf
                        <input type="hidden" value="{{"Задания на приеме заявок"}}" name="edit_type" id="edit_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Задания на приеме заявок</h4></button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_edit_post">
                        @csrf
                        <input type="hidden" value="{{"Задания в стадии выполнения"}}" name="edit_type" id="edit_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Задания в стадии выполнения<h4></button>
                    </form>
                </div>
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_edit_post">
                        @csrf
                        <input type="hidden" value="{{"Задания в стадии аттестации"}}" name="edit_type" id="edit_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Задания в стадии аттестации</h4></button>
                    </form>
                </div>
            <!--
                <div class="col-sm">
                    <form class="h-100" method="post" action="/missions/missions_edit_post">
                        @csrf
                        <input type="hidden" value="{{"Не актуальные задания"}}" name="edit_type" id="edit_type">
                        <button type="submit" class="btn btn-success h-100 w-100"><h4>Не актуальные задания</h4></button>
                    </form>
                </div>
             -->
            @endif
        </div>
    </div>
    <h4 class="text-center">{{$edit_type}}:</h4>
    @if($missions_edit == null)
        <h5 class="text-center">{{ $edit_type }} отсутствуют!</h5>
    @else
        @switch($edit_type)
            @case("Не выложенные задания")
                @foreach($missions_edit as $mission)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Название: {{ $mission->name }}</h5>
                                <p>Дата начала: {{ $mission->date_start }}</p>
                                @if (Route::has('route_missions_edit'))
                                    <form method="post" action="/missions/edit">
                                        @csrf
                                        <input type="hidden" value="{{ $mission->id }}" name="mission_id" id="mission_id">
                                        <input type="hidden" value="{{ $edit_type }}" name="edit_type" id="edit_type">
                                        <button type="submit" class="btn btn-success w-100"><h6>Открыть</h6></button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-2"></div>
                @endforeach
                @break
            @case("Задания на приеме заявок")
                @foreach($missions_edit as $mission)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Название: {{ $mission->name }}</h5>
                                <p>Дата начала приема заявок: {{ $mission->date_start_application }}</p>
                                @if (Route::has('route_missions_edit'))
                                    <form method="post" action="/missions/edit">
                                        @csrf
                                        <input type="hidden" value="{{ $mission->id }}" name="mission_id" id="mission_id">
                                        <input type="hidden" value="{{ $edit_type }}" name="edit_type" id="edit_type">
                                        <button type="submit" class="btn btn-success w-100"><h6>Открыть</h6></button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-2"></div>
                @endforeach
                @break
            @case("Задания в стадии выполнения")
                @foreach($missions_edit as $mission)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Название: {{ $mission->name }}</h5>
                                <p>Дата начала выполнения задания: {{ $mission->date_start_mission }}</p>
                                @if (Route::has('route_missions_edit'))
                                    <form method="post" action="/missions/edit">
                                        @csrf
                                        <input type="hidden" value="{{ $mission->id }}" name="mission_id" id="mission_id">
                                        <input type="hidden" value="{{ $edit_type }}" name="edit_type" id="edit_type">
                                        <button type="submit" class="btn btn-success w-100"><h6>Открыть</h6></button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-2"></div>
                @endforeach
                @break
            @case("Задания в стадии аттестации")
                @foreach($missions_edit as $mission)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Название: {{ $mission->name }}</h5>
                                <p>Дата начала аттестации: {{ $mission->date_start_attestation }}</p>
                                @if (Route::has('route_missions_edit'))
                                    <form method="post" action="/missions/edit">
                                        @csrf
                                        <input type="hidden" value="{{ $mission->id }}" name="mission_id" id="mission_id">
                                        <input type="hidden" value="{{ $edit_type }}" name="edit_type" id="edit_type">
                                        <button type="submit" class="btn btn-success w-100"><h6>Открыть</h6></button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-2"></div>
                @endforeach
                @break
            @case("Не актуальные задания")
                @foreach($missions_edit as $mission)
                    <div class="container bg-light rounded border border-primary">
                        <div class="row justify-content-center">
                            <div class="col text-center w-100 p-3 rounded border border-secondary">
                                <h5>Название: {{ $mission->name }}</h5>
                                <p>Дата окончания: {{ $mission->date_end }}</p>
                                @if (Route::has('route_missions_edit'))
                                    <form method="post" action="/missions/edit">
                                        @csrf
                                        <input type="hidden" value="{{ $mission->id }}" name="mission_id" id="mission_id">
                                        <input type="hidden" value="{{ $edit_type }}" name="edit_type" id="edit_type">
                                        <button type="submit" class="btn btn-success w-100"><h6>Открыть</h6></button>
                                    </form>
                                @endif
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

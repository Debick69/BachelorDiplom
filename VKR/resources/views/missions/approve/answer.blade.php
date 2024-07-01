@extends('missions.missions')

@section('under-missions')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col text-center">
                @if (Route::has('route_missions_approve_reject'))
                    <h4>Аргументируйте отказ:</h4>
                    <form method="post" action="/missions/approve/reject">
                        @csrf
                        <input class="w-100" type="text" name="answer" id="answer">
                        @if($fault == true)
                            <div class="container bg-warning text-white rounded">
                                <div class="row justify-content-center">
                                    <div class="col text-center">
                                        <p>Неверное значение ответа</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="p-2"></div>
                        <input type="hidden" value="{{ $approv_id }}" name="approv_id" id="approv_id">
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{ $approve_type }}" name="approve_type" id="approve_type">
                        <input type="hidden" value="{{ $option }}" name="option" id="option">
                        <button type="submit" class="btn btn-success w-100">Отправить</button>
                    </form>
                    <div class="p-2"></div>
                @endif
                @if (Route::has('route_missions_approve'))
                    <form method="post" action="/missions/approve">
                        @csrf
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{ $approve_type }}" name="approve_type" id="approve_type">
                        <button type="submit" class="btn btn-danger w-100">Отмена</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

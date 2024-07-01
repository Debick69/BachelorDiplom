@extends('missions.missions')

@section('under-missions')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ "Успешно" }}</div>
                <div class="card-body">
                    {{ "Изменено" }}
                </div>
                @if (Route::has('route_missions_approve'))
                    <div class="col-sm">
                        <form method="post" action="/missions/approve">
                            @csrf
                            <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                            <input type="hidden" value="{{$approve_type}}" name="approve_type" id="approve_type">
                            <button type="submit" class="btn btn-success w-100">Вернуться</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

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
                @if (Route::has('route_missions_reports'))
                    <form method="post" action="/missions/reports">
                        @csrf
                        <input type="hidden" value="{{ $mission_id }}" name="mission_id" id="mission_id">
                        <input type="hidden" value="{{ $reports_type }}" name="reports_type" id="reports_type">
                        <button type="submit" class="btn btn-success w-100">Вернуться</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

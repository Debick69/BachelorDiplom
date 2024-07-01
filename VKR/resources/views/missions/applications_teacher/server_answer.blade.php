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
                @if (Route::has('route_missions_missions_applications_teacher'))
                    <div class="col-sm">
                        <form method="get" action="/missions/missions_applications_teacher">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">Вернуться</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

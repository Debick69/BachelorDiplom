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
                @if (Route::has('route_missions_missions_applications_teacher_mine_post'))
                    <div class="col-sm">
                        <form class="h-100" method="post" action="/missions/missions_applications_teacher_mine_post">
                            @csrf
                            <input type="hidden" value="{{ $applications_type }}" name="applications_type" id="applications_type">
                            <button type="submit" class="btn btn-success h-100 w-100">Вернуться</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

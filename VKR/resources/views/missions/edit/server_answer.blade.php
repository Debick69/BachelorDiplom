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
                @if (Route::has('route_missions_missions_edit_post'))
                    <div class="col-sm">
                        <form method="post" action="/missions/missions_edit_post">
                            @csrf
                            <input type="hidden" value="{{$edit_type}}" name="edit_type" id="edit_type">
                            <button type="submit" class="btn btn-success w-100">Вернуться</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

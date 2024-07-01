@extends('missions.missions')

@section('under-missions')
    <h4 class="text-center">Выберите индивидуальное задание:</h4>
    @if($missions_reports == null)
        <h5 class="text-center">Индивидуальных заданий на аттестации нет!</h5>
    @else
        @foreach($missions_reports as $mission)
            <div class="container bg-light rounded border border-primary">
                <div class="row justify-content-center">
                    <div class="col text-center w-100 p-3 rounded border border-secondary">
                        <h5>Название: {{ $mission->name }}</h5>
                        <p>Количество отчетов: {{ $mission->reports_count }}</p>
                        <p>Дата начала аттестации: {{ $mission->date_start_attestation }}</p>
                        @if (Route::has('route_missions_reports'))
                            <form method="post" action="/missions/reports">
                                @csrf
                                <input type="hidden" value="{{ $mission->id }}" name="mission_id" id="mission_id">
                                <input type="hidden" value="{{ "Отчеты на рассмотрении" }}" name="reports_type" id="reports_type">
                                <button type="submit" class="btn btn-success w-100">Открыть</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="p-2"></div>
        @endforeach
    @endif
@endsection

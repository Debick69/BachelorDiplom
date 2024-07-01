<?php

namespace App\Http\Controllers\Missions\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class MissionsReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function take_missions_reports()
    {
        $missions_reports = null;
        $state_report = "На рассмотрении";
        $id = Auth::user()->id;
        $missions_reports = DB::select('select *, (select count(*) from report_user where report_user.id_mission = missions.id and report_user.state = ?) as reports_count from missions where missions.date_start_attestation <= NOW() and missions.date_end_attestation >= NOW() and missions.id_vice_rector = ? order by missions.date_start_application desc', [$state_report, $id]);
        return $missions_reports;
    }

    public function missions_missions_reports()
    {
        $role = $this->take_role();
        $missions_reports = $this->take_missions_reports();
        $location = 'Отчеты';
        return view('missions.reports.missions_reports', compact('role','location', 'missions_reports'));
    }
}

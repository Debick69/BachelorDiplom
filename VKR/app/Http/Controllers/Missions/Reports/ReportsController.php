<?php

namespace App\Http\Controllers\Missions\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function take_missions_reports($mission_id, $reports_type)
    {
        $reports = null;
        $reports = DB::select('select report_user.*, users.name, (select answer.text from answer, answer_report where answer.id = answer_report.id_answer and answer_report.id_user_report = report_user.id order by answer.datetime desc limit 1) as answer_text from report_user, users where report_user.id_mission = ? and report_user.id_user = users.id and report_user.state = ? order by report_user.date desc', [$mission_id, $reports_type]);
        return $reports;
    }

    public function take_reports_type_DB($reports_type)
    {
        $reports_type_DB = null;
        switch ($reports_type)
        {
            case "Отчеты на рассмотрении":
                $reports_type_DB = "На рассмотрении";
                break;
            case "Отклоненные отчеты":
                $reports_type_DB = "Отказано";
                break;
            case "Принятые отчеты":
                $reports_type_DB = "Одобрено";
                break;
            default:
                break;
        }
        return $reports_type_DB;
    }

    public function missions_reports(Request $request)
    {
        $mission_id = $request->input('mission_id');
        $reports_type = $request->input('reports_type');
        $reports_type_DB = $this->take_reports_type_DB($reports_type);
        $reports = $this->take_missions_reports($mission_id, $reports_type_DB);
        $role = $this->take_role();
        $location = 'Отчеты';
        return view('missions.reports.reports', compact('role','location', 'mission_id', 'reports_type', 'reports'));
    }
}

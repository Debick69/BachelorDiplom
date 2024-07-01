<?php

namespace App\Http\Controllers\Missions\ReportsTeacherMine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class MissionsReportsTeacherMineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function take_missions_reports($reports_type_DB)
    {
        $missions_reports = null;
        $id = Auth::user()->id;
        $missions_reports = DB::select('select missions.id as mission_id, missions.name, missions.text as missions_text, missions.max_score, missions.max_workers, missions.date_start, missions.date_start_application, missions.date_end_application, missions.date_start_mission, missions.date_end_mission, missions.date_start_attestation, missions.date_end_attestation, missions.date_end, report_user.*, (select users.name from users where missions.id_vice_rector = users.id) as name_vice_rector, (select answer.text from answer, answer_report where answer.id = answer_report.id_answer and answer_report.id_user_report = report_user.id order by answer.datetime desc limit 1) as answer_text from missions, report_user where missions.id = report_user.id_mission and report_user.id_user = ? and missions.date_start_attestation <= NOW() and missions.date_end_attestation >= NOW() and report_user.state = ? order by missions.date_start_attestation desc', [$id, $reports_type_DB]);
        return $missions_reports;
    }

    public function missions_missions_reports_teacher_mine()
    {
        $reports_type = "Не выложенные отчеты";
        $view = $this->missions_missions_reports_teacher_mine_open($reports_type);
        return $view;
    }

    public function missions_missions_reports_teacher_mine_post(Request $request)
    {
        $reports_type = $request->input('reports_type');
        $view = $this->missions_missions_reports_teacher_mine_open($reports_type);
        return $view;
    }

    public function take_reports_type_DB($reports_type)
    {
        $reports_type_DB = null;
        switch ($reports_type)
        {
            case "Не выложенные отчеты":
                $reports_type_DB = "Не выложено";
                break;
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

    public function missions_missions_reports_teacher_mine_open($reports_type)
    {
        $role = $this->take_role();
        $reports_type_DB = $this->take_reports_type_DB($reports_type);
        $missions_reports = $this->take_missions_reports($reports_type_DB);
        $location = 'Отчеты';
        return view('missions.reports_teacher_mine.missions_reports_teacher_mine', compact('role','location', 'missions_reports', 'reports_type'));    }
}

<?php

namespace App\Http\Controllers\Missions\ReportsTeacherMine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class MissionsReportsTeacherMineReworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function missions_missions_reports_teacher_mine_rework(Request $request)
    {
        $report_id = $request->input('report_id');
        $reports_type = $request->input('reports_type');
        $mission_id = $request->input('mission_id');
        switch ($reports_type)
        {
            case "Не выложенные отчеты":
                $fault = $request->input('fault');
                $view = $this->repeat_report_open($mission_id, $reports_type, $fault, $report_id);
                break;
            case "Отчеты на рассмотрении":
                $this->cancel_application($report_id);
                $view = $this->server_answer_open($reports_type);
                break;
            case "Отклоненные отчеты":
                $fault = $request->input('fault');
                $view = $this->repeat_report_open($mission_id, $reports_type, $fault, $report_id);
                break;
            default:
                break;
        }
        return $view;
    }

    public function cancel_application($report_id)
    {
        $reports_type_DB = "Отказано";
        DB::update('update report_user set report_user.state = ?, report_user.rating = null, report_user.date = null where report_user.id = ?', [$reports_type_DB, $report_id]);

        $true_id_vice_rectors = 0;
        $id_vice_rectors = DB::select('select missions.id_vice_rector from missions, report_user where missions.id = report_user.id_mission and report_user.id = ?', [$report_id]);
        foreach ($id_vice_rectors as $id_vice_rector)
        {
            $true_id_vice_rectors = $id_vice_rector->id_vice_rector;
        }
        $this->add_notification($true_id_vice_rectors, "Отчет был отозван", "Новое!");

        return 0;
    }

    public function server_answer_open($reports_type)
    {
        $role = $this->take_role();
        $location = 'Отчеты';
        return view('missions.reports_teacher_mine.server_answer', compact('role','location', 'reports_type'));
    }

    public function repeat_report_open($mission_id, $reports_type, $fault, $report_id)
    {
        $mission = $this->take_mission($mission_id);
        $role = $this->take_role();
        $location = 'Отчеты';
        return view('missions.reports_teacher_mine.repeat_report', compact('role','location', 'mission', 'fault', 'reports_type', 'report_id'));
    }

    public function take_mission($mission_id)
    {
        $true_mission = null;
        $missions = DB::select('select * from missions where missions.id = ?', [$mission_id]);
        foreach ($missions as $mission)
        {
            $true_mission = $mission;
        }
        return $true_mission;
    }

    public function missions_reports_teacher_mine_accept(Request $request)
    {
        $mission_id = $request->input('mission_id');
        $report_id = $request->input('report_id');
        $reports_teacher_text = $request->input('reports_teacher_text');
        $reports_type = $request->input('reports_type');
        $check_answer = $this->check_answer($reports_teacher_text);
        if($check_answer)
        {
            $this->update_report($report_id, $reports_teacher_text);
            $view = $this->server_answer_open($reports_type);
        }
        else
        {
            $fault = true;
            $view = $this->repeat_report_open($mission_id, $reports_type, $fault, $report_id);
        }
        return $view;
    }

    public function update_report($report_id, $reports_teacher_text)
    {
        $reports_type_DB = "На рассмотрении";
        DB::update('update report_user set report_user.state = ?, report_user.text = ?, report_user.date = NOW() where report_user.id = ?', [$reports_type_DB, $reports_teacher_text, $report_id]);

        $true_id_vice_rectors = 0;
        $id_vice_rectors = DB::select('select missions.id_vice_rector from missions, report_user where missions.id = report_user.id_mission and report_user.id = ?', [$report_id]);
        foreach ($id_vice_rectors as $id_vice_rector)
        {
            $true_id_vice_rectors = $id_vice_rector->id_vice_rector;
        }
        $this->add_notification($true_id_vice_rectors, "Новый отчет", "Новое!");

        return 0;
    }

    public function check_answer($answer)
    {
        if ($answer != null)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

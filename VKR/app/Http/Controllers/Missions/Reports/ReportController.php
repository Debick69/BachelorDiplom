<?php

namespace App\Http\Controllers\Missions\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function missions_report_open($mission_id, $reports_type, $report_id, $fault, $option)
    {
        $role = $this->take_role();
        $location = 'Отчеты';
        return view('missions.reports.report', compact('role','location', 'mission_id', 'reports_type', 'report_id', 'option', 'fault'));
    }

    public function missions_report(Request $request)
    {
        $mission_id = $request->input('mission_id');
        $reports_type = $request->input('reports_type');
        $report_id = $request->input('report_id');
        $fault = $request->input('fault');
        $option = null;
        if($reports_type == "Отчеты на рассмотрении")
        {
            $option = $request->input('option');
        }
        $view = $this->missions_report_open($mission_id, $reports_type, $report_id, $fault, $option);
        return $view;
    }

    public function server_answer_open($mission_id, $reports_type)
    {
        $role = $this->take_role();
        $location = 'Отчеты';
        return view('missions.reports.server_answer', compact('role','location', 'mission_id', 'reports_type'));
    }

    public function check_rating($rating)
    {
        if ($rating <= 5 && $rating > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
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

    public function change_report_rating($report_id, $rating)
    {
        $reports_type_DB = "Одобрено";
        DB::update('update report_user set report_user.state = ?, report_user.rating = ? where report_user.id = ?', [$reports_type_DB, $rating, $report_id]);

        $true_id_user = 0;
        $id_users = DB::select('select report_user.id_user from missions, report_user where missions.id = report_user.id_mission and report_user.id = ?', [$report_id]);
        foreach ($id_users as $id_user)
        {
            $true_id_user = $id_user->id_user;
        }
        $this->add_notification($true_id_user, "Отчет одобрили", "Новое!");

        return 0;
        //уведомление преподу о одобрении ИЗ
    }

    public function missions_report_accept(Request $request)
    {
        $report_id = $request->input('report_id');
        $reports_type = $request->input('reports_type');
        $mission_id = $request->input('mission_id');
        $rating = $request->input('rating');
        $option = $request->input('option');
        $check_rating = $this->check_rating($rating);
        $view = null;
        if ($check_rating)
        {
            $this->change_report_rating($report_id, $rating);
            $view = $this->server_answer_open($mission_id, $reports_type);
        }
        else
        {
            $fault = true;
            $view = $this->missions_report_open($mission_id, $reports_type, $report_id, $fault, $option);
        }
        return $view;
    }

    public function missions_report_reject(Request $request)
    {
        $report_id = $request->input('report_id');
        $reports_type = $request->input('reports_type');
        $mission_id = $request->input('mission_id');
        $answer = $request->input('answer');
        $option = $request->input('option');
        $check_answer = $this->check_answer($answer);
        $view = null;
        if($check_answer)
        {
            $this->add_answer($report_id, $answer);
            $view = $this->server_answer_open($mission_id, $reports_type);
        }
        else
        {
            $fault = true;
            $view = $this->missions_report_open($mission_id, $reports_type, $report_id, $fault, $option);
        }
        return $view;
    }

    public function add_answer($report_id, $answer)
    {
        $state = "Отказано";
        $true_id_answer = 0;
        $id_answers = DB::select('select * from answer order by answer.id desc limit 1');
        foreach ($id_answers as $id_answer) {
            $true_id_answer = $id_answer->id;
        }
        $true_id_answer += 1;
        DB::insert('insert into answer (answer.id, answer.text, answer.datetime) VALUES (?, ?, NOW())', [$true_id_answer, $answer]);
        DB::insert('insert into answer_report (answer_report.id_user_report, answer_report.id_answer) VALUES (?, ?)', [$report_id, $true_id_answer]);
        DB::update('update report_user set report_user.state = ?, report_user.rating = null where report_user.id = ?', [$state, $report_id]);

        $true_id_user = 0;
        $id_users = DB::select('select report_user.id_user from missions, report_user where missions.id = report_user.id_mission and report_user.id = ?', [$report_id]);
        foreach ($id_users as $id_user)
        {
            $true_id_user = $id_user->id_user;
        }
        $this->add_notification($true_id_user, "Отчет не одобрили", "Новое!");

        return 0;
        //уведомления об отказаном ИЗ
    }
}

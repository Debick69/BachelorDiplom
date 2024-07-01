<?php

namespace App\Http\Controllers\Missions\Approve;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class ApproveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function take_missions_approve($mission_id, $approve_type)
    {
        $approve = null;
        $approve = DB::select('select application_user.*, users.name, users.id as user_id from application_user, users where application_user.id_mission = ? and application_user.id_user = users.id and application_user.state = ? order by application_user.date desc', [$mission_id, $approve_type]);
        return $approve;
    }

    public function take_approve_type_DB($approve_type)
    {
        $approve_type_DB = null;
        switch ($approve_type)
        {
            case "Принятые заявки проректором (подтверждено преподавателем)":
                $approve_type_DB = "Одобрено";
                break;
            case "Принятые заявки проректором (одобрено ректором)":
                $approve_type_DB = "Одобрено ректором";
                break;
            default:
                break;
        }
        return $approve_type_DB;
    }

    public function missions_approve(Request $request)
    {
        $mission_id = $request->input('mission_id');
        $approve_type = $request->input('approve_type');
        $approve_type_DB = $this->take_approve_type_DB($approve_type);
        $approve = $this->take_missions_approve($mission_id, $approve_type_DB);
        $role = $this->take_role();
        $location = 'Утверждение';
        return view('missions.approve.approve', compact('role','location', 'mission_id', 'approve_type', 'approve'));
    }

    public function approve($approv_id, $mission_id, $user_id)
    {
        $approve_type_DB = "Одобрено ректором";
        $state = "Не выложено";
        DB::update('update application_user set application_user.state = ? where application_user.id = ?', [$approve_type_DB, $approv_id]);
        DB::insert('insert into report_user (report_user.id_user, report_user.id_mission, report_user.state) VALUES (?, ?, ?)', [$user_id, $mission_id, $state]);

        $true_id_user = 0;
        $id_users = DB::select('select application_user.id_user from missions, application_user where missions.id = application_user.id_mission and application_user.id_mission = ?', [$mission_id]);
        foreach ($id_users as $id_user)
        {
            $true_id_user = $id_user->id_user;
        }
        $this->add_notification($true_id_user, "Ректор одобрил задание", "Новое!");

        return 0;
    }

    public function missions_approv(Request $request)
    {
        $mission_id = $request->input('mission_id');
        $approve_type = $request->input('approve_type');
        $user_id = $request->input('user_id');
        $approv_id = $request->input('approv_id');
        $fault = $request->input('fault');
        $option = $request->input('option');
        if($option)
        {
            $this->approve($approv_id, $mission_id, $user_id);
            $view = $this->server_answer_open($mission_id, $approve_type);
        }
        else
        {
            $view = $this->answer_open($mission_id, $approve_type, $fault, $approv_id, $option);
        }
        return $view;
    }

    public function server_answer_open($mission_id, $approve_type)
    {
        $role = $this->take_role();
        $location = 'Утверждение';
        return view('missions.approve.server_answer', compact('role','location', 'mission_id', 'approve_type'));
    }

    public function answer_open($mission_id, $approve_type, $fault, $approv_id, $option)
    {
        $role = $this->take_role();
        $location = 'Утверждение';
        return view('missions.approve.answer', compact('role','location', 'mission_id', 'approve_type', 'fault', 'approv_id', 'option'));
    }

    public function missions_approve_reject(Request $request)
    {
        $approv_id = $request->input('approv_id');
        $approve_type = $request->input('approve_type');
        $mission_id = $request->input('mission_id');
        $answer = $request->input('answer');
        $option = $request->input('option');
        $check_answer = $this->check_answer($answer);
        $view = null;
        if($check_answer)
        {
            $this->add_answer($approv_id, $answer);
            $view = $this->server_answer_open($mission_id, $approve_type);
        }
        else
        {
            $fault = true;
            $view = $this->answer_open($mission_id, $approve_type, $fault, $approv_id, $option);
        }
        return $view;
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

    public function add_answer($application_id, $answer)
    {
        $state = "Отказано";
        $true_id_answer = 0;
        $id_answers = DB::select('select * from answer order by answer.id desc limit 1');
        foreach ($id_answers as $id_answer) {
            $true_id_answer = $id_answer->id;
        }
        $true_id_answer += 1;
        DB::insert('insert into answer (answer.id, answer.text, answer.datetime) VALUES (?, ?, NOW())', [$true_id_answer, $answer]);
        DB::insert('insert into answer_application (answer_application.id_user_application, answer_application.id_answer) VALUES (?, ?)', [$application_id, $true_id_answer]);
        DB::update('update application_user set application_user.state = ?, application_user.score = null where application_user.id = ?', [$state, $application_id]);

        $true_id_user = 0;
        $id_users = DB::select('select application_user.id_user from missions, application_user where missions.id = application_user.id_mission and application_user.id = ?', [$application_id]);
        foreach ($id_users as $id_user)
        {
            $true_id_user = $id_user->id_user;
        }
        $this->add_notification($true_id_user, "Задание не одобрили задание", "Новое!");

        return 0;
        //уведомление преподу об отказаной заявки
    }
}

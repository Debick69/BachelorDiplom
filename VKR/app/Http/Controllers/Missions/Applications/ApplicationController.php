<?php

namespace App\Http\Controllers\Missions\Applications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function missions_application_open($mission_id, $applications_type, $application_id, $fault, $mxfault, $option)
    {
        $role = $this->take_role();
        $location = 'Заявки';
        return view('missions.applications.application', compact('role','location', 'mission_id', 'applications_type', 'application_id', 'option', 'fault', 'mxfault'));
    }

    public function missions_application(Request $request)
    {
        $mission_id = $request->input('mission_id');
        $applications_type = $request->input('applications_type');
        $application_id = $request->input('application_id');
        $fault = $request->input('fault');
        $mxfault = $request->input('mxfault');
        $option = null;
        if($applications_type == "Заявки на рассмотрении")
        {
            $option = $request->input('option');
        }
        $view = $this->missions_application_open($mission_id, $applications_type, $application_id, $fault, $mxfault, $option);
        return $view;
    }

    public function server_answer_open($mission_id, $applications_type)
    {
        $role = $this->take_role();
        $location = 'Заявки';
        return view('missions.applications.server_answer', compact('role','location', 'mission_id', 'applications_type'));
    }

    public function check_score($score, $mission_id)
    {
        $true_mission_score = 0;
        $missions_score = DB::select('select missions.max_score from missions where missions.id = ? order by missions.id desc limit 1', [$mission_id]);
        foreach ($missions_score as $mission_score) {
            $true_mission_score = $mission_score->max_score;
        }
        if ($score <= $true_mission_score && $score > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_max_workers($mission_id)
    {
        $true_mission_max_workers = 0;
        $true_applications_count1 = 0;
        $true_applications_count2 = 0;
        $true_applications_count3 = 0;
        $state_answer1 = "Ожидает ответа";
        $state_answer2 = "Одобрено";
        $state_answer3 = "Одобрено ректором";
        $missions_max_workers = DB::select('select missions.max_workers from missions where missions.id = ? order by missions.id desc limit 1', [$mission_id]);
        $applications_count1 = DB::select('select count(*) as applic_count from application_user where application_user.id_mission = ? and application_user.state = ?', [$mission_id, $state_answer1]);
        $applications_count2 = DB::select('select count(*) as applic_count from application_user where application_user.id_mission = ? and application_user.state = ?', [$mission_id, $state_answer2]);
        $applications_count3 = DB::select('select count(*) as applic_count from application_user where application_user.id_mission = ? and application_user.state = ?', [$mission_id, $state_answer3]);
        foreach ($missions_max_workers as $mission_max_workers) {
            $true_mission_max_workers = $mission_max_workers->max_workers;
        }
        foreach ($applications_count1 as $application_count1) {
            $true_applications_count1 = $application_count1->applic_count;
        }
        foreach ($applications_count2 as $application_count2) {
            $true_applications_count2 = $application_count2->applic_count;
        }
        foreach ($applications_count3 as $application_count3) {
            $true_applications_count3 = $application_count3->applic_count;
        }
        if($true_applications_count1 + $true_applications_count2 + $true_applications_count3 < $true_mission_max_workers)
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

    public function change_application_score($application_id, $score)
    {
        $applications_type_DB = "Ожидает ответа";
        DB::update('update application_user set application_user.state = ?, application_user.score = ? where application_user.id = ?', [$applications_type_DB, $score, $application_id]);

        $true_id_user = 0;
        $id_users = DB::select('select application_user.id_user from missions, application_user where missions.id = application_user.id_mission and application_user.id = ?', [$application_id]);
        foreach ($id_users as $id_user)
        {
            $true_id_user = $id_user->id_user;
        }
        $this->add_notification($true_id_user, "Проректор одобрил задание", "Новое!");
        return 0;
    }

    public function missions_application_accept(Request $request)
    {
        $application_id = $request->input('application_id');
        $applications_type = $request->input('applications_type');
        $mission_id = $request->input('mission_id');
        $score = $request->input('score');
        $option = $request->input('option');
        $check_score = $this->check_score($score, $mission_id);
        $check_max_workers = $this->check_max_workers($mission_id);
        $view = null;
        if ($check_score)
        {
            if($check_max_workers)
            {
                $this->change_application_score($application_id, $score);
                $view = $this->server_answer_open($mission_id, $applications_type);
            }
            else
            {
                $mxfault = true;
                $fault = false;
                $view = $this->missions_application_open($mission_id, $applications_type, $application_id, $fault, $mxfault, $option);
            }
        }
        else
        {
            $fault = true;
            $mxfault = false;
            $view = $this->missions_application_open($mission_id, $applications_type, $application_id, $fault, $mxfault, $option);
        }
        return $view;
    }

    public function missions_application_reject(Request $request)
    {
        $application_id = $request->input('application_id');
        $applications_type = $request->input('applications_type');
        $mission_id = $request->input('mission_id');
        $answer = $request->input('answer');
        $option = $request->input('option');
        $check_answer = $this->check_answer($answer);
        $view = null;
        if($check_answer)
        {
            $this->add_answer($application_id, $answer);
            $view = $this->server_answer_open($mission_id, $applications_type);
        }
        else
        {
            $fault = true;
            $mxfault = false;
            $view = $this->missions_application_open($mission_id, $applications_type, $application_id, $fault, $mxfault, $option);
        }
        return $view;
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
        $this->add_notification($true_id_user, "Проректор не одобрил задание", "Новое!");
        return 0;
    }
}

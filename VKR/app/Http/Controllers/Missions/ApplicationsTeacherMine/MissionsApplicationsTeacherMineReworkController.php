<?php

namespace App\Http\Controllers\Missions\ApplicationsTeacherMine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class MissionsApplicationsTeacherMineReworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function missions_missions_applications_teacher_mine_rework(Request $request)
    {
        $application_id = $request->input('application_id');
        $applications_type = $request->input('applications_type');
        $mission_id = $request->input('mission_id');
        $option = null;
        switch ($applications_type)
        {
            case "Заявки на рассмотрении":
                $this->cancel_application($application_id);
                $view = $this->server_answer_open($applications_type);
                break;
            case "Отклоненные заявки":
                $fault = $request->input('fault');
                $view = $this->repeat_application_open($mission_id, $applications_type, $fault, $application_id);
                break;
            case "Принятые заявки проректором (ожидание подтверждения от преподавателя)":
                $option = $request->input('option');
                if($option)
                {
                    $this->accept_application($application_id);
                }
                else
                {
                    $this->cancel_application($application_id);
                }
                $view = $this->server_answer_open($applications_type);
                break;
            case "Принятые заявки проректором (подтверждено преподавателем)":
                $this->cancel_application($application_id);
                $view = $this->server_answer_open($applications_type);
                break;
            default:
                break;
        }
        return $view;
    }

    public function cancel_application($application_id)
    {
        $applications_type_DB = "Отказано";
        DB::update('update application_user set application_user.state = ?, application_user.score = null where application_user.id = ?', [$applications_type_DB, $application_id]);

        $true_id_vice_rectors = 0;
        $id_vice_rectors = DB::select('select missions.id_vice_rector from missions, application_user where missions.id = application_user.id_mission and application_user.id = ?', [$application_id]);
        foreach ($id_vice_rectors as $id_vice_rector)
        {
            $true_id_vice_rectors = $id_vice_rector->id_vice_rector;
        }
        $this->add_notification($true_id_vice_rectors, "Одна из заявок была отозвана", "Новое!");

        return 0;
    }

    public function accept_application($application_id)
    {
        $applications_type_DB = "Одобрено";
        DB::update('update application_user set application_user.state = ? where application_user.id = ?', [$applications_type_DB, $application_id]);

        $true_id_vice_rectors = 0;
        $id_vice_rectors = DB::select('select missions.id_vice_rector from missions, application_user where missions.id = application_user.id_mission and application_user.id = ?', [$application_id]);
        foreach ($id_vice_rectors as $id_vice_rector)
        {
            $true_id_vice_rectors = $id_vice_rector->id_vice_rector;
        }
        $this->add_notification($true_id_vice_rectors, "Заявка принята преподавателем", "Новое!");

        return 0;
    }

    public function server_answer_open($applications_type)
    {
        $role = $this->take_role();
        $location = 'Мои заявки';
        return view('missions.applications_teacher_mine.server_answer', compact('role','location', 'applications_type'));
    }

    public function repeat_application_open($mission_id, $applications_type, $fault, $application_id)
    {
        $mission = $this->take_mission($mission_id);
        $role = $this->take_role();
        $location = 'Мои заявки';
        return view('missions.applications_teacher_mine.repeat_application', compact('role','location', 'mission', 'fault', 'applications_type', 'application_id'));
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

    public function missions_applications_teacher_mine_accept(Request $request)
    {
        $mission_id = $request->input('mission_id');
        $application_id = $request->input('application_id');
        $applications_teacher_text = $request->input('applications_teacher_text');
        $applications_type = $request->input('applications_type');
        $check_answer = $this->check_answer($applications_teacher_text);
        if($check_answer)
        {
            $this->update_application($application_id, $applications_teacher_text);
            $view = $this->server_answer_open($applications_type);
        }
        else
        {
            $fault = true;
            $view = $this->repeat_application_open($mission_id, $applications_type, $fault, $application_id);
        }
        return $view;
    }

    public function update_application($application_id, $applications_teacher_text)
    {
        $applications_type_DB = "На рассмотрении";
        DB::update('update application_user set application_user.state = ?, application_user.text = ? where application_user.id = ?', [$applications_type_DB, $applications_teacher_text, $application_id]);

        $true_id_vice_rectors = 0;
        $id_vice_rectors = DB::select('select missions.id_vice_rector from missions, application_user where missions.id = application_user.id_mission and application_user.id = ?', [$application_id]);
        foreach ($id_vice_rectors as $id_vice_rector)
        {
            $true_id_vice_rectors = $id_vice_rector->id_vice_rector;
        }
        $this->add_notification($true_id_vice_rectors, "Новая заявка", "Новое!");

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

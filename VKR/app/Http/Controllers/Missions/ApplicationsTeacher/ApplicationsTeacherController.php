<?php

namespace App\Http\Controllers\Missions\ApplicationsTeacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class ApplicationsTeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

    public function missions_applications_teacher(Request $request)
    {
        $mission_id = $request->input('mission_id');
        $fault = $request->input('fault');
        $mxfault = $request->input('mxfault');
        $view = $this->missions_applications_teacher_open($mission_id, $fault, $mxfault);
        return $view;
    }

    public function  missions_applications_teacher_open($mission_id, $fault, $mxfault)
    {
        $mission = $this->take_mission($mission_id);
        $role = $this->take_role();
        $location = 'Подача заявки';
        return view('missions.applications_teacher.applications_teacher', compact('role','location', 'mission', 'fault', 'mxfault'));
    }

    public function check_applications($mission_id)
    {
        $true_application_count = null;
        $id = Auth::user()->id;
        $applications = DB::select('select count(*) as applications_count from application_user where application_user.id_mission = ? and application_user.id_user = ? ', [$mission_id, $id]);
        foreach ($applications as $application)
        {
            $true_application_count = $application->applications_count;
        }
        if($true_application_count == null)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function missions_applications_teacher_accept(Request $request)
    {
        $mission_id = $request->input('mission_id');
        $applications_teacher_text = $request->input('applications_teacher_text');
        $check_answer = $this->check_answer($applications_teacher_text);
        $check_applications = $this->check_applications($mission_id);
        if($check_answer)
        {
            if($check_applications)
            {
                $this->add_application($mission_id, $applications_teacher_text);
                $view = $this->server_answer_open();
            }
            else
            {
                $mxfault = true;
                $fault = false;
                $view = $this->missions_applications_teacher_open($mission_id, $fault, $mxfault);
            }
        }
        else
        {
            $fault = true;
            $mxfault = false;
            $view = $this->missions_applications_teacher_open($mission_id, $fault, $mxfault);
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

    public function add_application($mission_id, $applications_teacher_text)
    {
        $state = "На рассмотрении";
        $true_id_application_user = 0;
        $id = Auth::user()->id;
        $id_applications_user = DB::select('select * from application_user order by application_user.id desc limit 1');
        foreach ($id_applications_user as $id_application_user) {
            $true_id_application_user = $id_application_user->id;
        }
        $true_id_application_user += 1;
        DB::insert('insert into application_user (application_user.id, application_user.id_user, application_user.id_mission, application_user.state, application_user.text, application_user.date) VALUES (?, ?, ?, ?, ?, NOW())', [$true_id_application_user, $id, $mission_id, $state, $applications_teacher_text]);

        $true_id_vice_rectors = 0;
        $id_vice_rectors = DB::select('select missions.id_vice_rector from missions where missions.id = ?', [$mission_id]);
        foreach ($id_vice_rectors as $id_vice_rector)
        {
            $true_id_vice_rectors = $id_vice_rector->id_vice_rector;
        }
        $this->add_notification($true_id_vice_rectors, "Новое!", "Новая заявка");
        return 0;
    }

    public function server_answer_open()
    {
        $role = $this->take_role();
        $location = 'Подача заявки';
        return view('missions.applications_teacher.server_answer', compact('role','location'));
    }
}

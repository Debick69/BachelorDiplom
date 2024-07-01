<?php

namespace App\Http\Controllers\Missions\Applications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class ApplicationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function take_missions_applications($mission_id, $applications_type)
    {
        $applications = null;
        $applications = DB::select('select application_user.*, users.name, (select answer.text from answer, answer_application where answer.id = answer_application.id_answer and answer_application.id_user_application = application_user.id) as answer_text from application_user, users where application_user.id_mission = ? and application_user.id_user = users.id and application_user.state = ? order by application_user.date desc', [$mission_id, $applications_type]);
        return $applications;
    }

    public function take_applications_type_DB($applications_type)
    {
        $applications_type_DB = null;
        switch ($applications_type)
        {
            case "Заявки на рассмотрении":
                $applications_type_DB = "На рассмотрении";
                break;
            case "Отклоненные заявки":
                $applications_type_DB = "Отказано";
                break;
            case "Принятые заявки проректором (ожидание подтверждения от преподавателя)":
                $applications_type_DB = "Ожидает ответа";
                break;
            case "Принятые заявки проректором (подтверждено преподавателем)":
                $applications_type_DB = "Одобрено";
                break;
            case "Принятые заявки проректором (одобрено ректором)":
                $applications_type_DB = "Одобрено ректором";
                break;
            default:
                break;
        }
        return $applications_type_DB;
    }

    public function missions_applications(Request $request)
    {
        $mission_id = $request->input('mission_id');
        $applications_type = $request->input('applications_type');
        $applications_type_DB = $this->take_applications_type_DB($applications_type);
        $applications = $this->take_missions_applications($mission_id, $applications_type_DB);
        $role = $this->take_role();
        $location = 'Заявки';
        return view('missions.applications.applications', compact('role','location', 'mission_id', 'applications_type', 'applications'));
    }
}

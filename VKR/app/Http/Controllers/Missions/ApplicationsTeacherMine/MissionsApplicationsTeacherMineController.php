<?php

namespace App\Http\Controllers\Missions\ApplicationsTeacherMine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class MissionsApplicationsTeacherMineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function take_missions_applications($applications_type_DB)
    {
        $missions_applications = null;
        $id = Auth::user()->id;
        $missions_applications = DB::select('select missions.id as mission_id, missions.name, missions.text as missions_text, missions.max_score, missions.max_workers, missions.date_start, missions.date_start_application, missions.date_end_application, missions.date_start_mission, missions.date_end_mission, missions.date_start_attestation, missions.date_end_attestation, missions.date_end, application_user.*, (select users.name from users where missions.id_vice_rector = users.id) as name_vice_rector, (select answer.text from answer, answer_application where answer.id = answer_application.id_answer and answer_application.id_user_application = application_user.id order by answer.datetime desc limit 1) as answer_text from missions, application_user where missions.id = application_user.id_mission and application_user.id_user = ? and application_user.state = ?', [$id, $applications_type_DB]);
        return $missions_applications;
    }

    public function missions_missions_applications_teacher_mine()
    {
        $applications_type = "Заявки на рассмотрении";
        $view = $this->missions_missions_applications_teacher_mine_open($applications_type);
        return $view;
    }

    public function missions_missions_applications_teacher_mine_post(Request $request)
    {
        $applications_type = $request->input('applications_type');
        $view = $this->missions_missions_applications_teacher_mine_open($applications_type);
        return $view;
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

    public function missions_missions_applications_teacher_mine_open($applications_type)
    {
        $role = $this->take_role();
        $applications_type_DB = $this->take_applications_type_DB($applications_type);
        $missions_applications = $this->take_missions_applications($applications_type_DB);
        $location = 'Мои заявки';
        return view('missions.applications_teacher_mine.missions_applications_teacher_mine', compact('role','location', 'missions_applications', 'applications_type'));
    }
}

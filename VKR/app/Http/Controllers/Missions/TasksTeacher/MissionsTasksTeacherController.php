<?php

namespace App\Http\Controllers\Missions\TasksTeacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class MissionsTasksTeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function take_missions_tasks_teacher()
    {
        $missions_tasks_teacher = null;
        $id = Auth::user()->id;
        $missions_tasks_teacher = DB::select('select missions.*, (select application_user.score from application_user where application_user.id_user = ? and application_user.id_mission = missions.id) as application_score from missions, report_user where missions.date_start_mission <= NOW() and missions.date_end_mission >= NOW() and missions.id = report_user.id_mission and report_user.id_user = ? order by missions.date_start_mission desc', [$id, $id]);
        return $missions_tasks_teacher;
    }

    public function missions_missions_tasks_teacher()
    {
        $role = $this->take_role();
        $missions_tasks_teacher = $this->take_missions_tasks_teacher();
        $location = 'Выполняющиеся_ИЗ';
        return view('missions.tasks_teacher.missions_tasks_teacher', compact('role','location', 'missions_tasks_teacher'));
    }
}

<?php

namespace App\Http\Controllers\Missions\TasksTeacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class TasksTeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function missions_tasks_teacher(Request $request)
    {
        $mission_id = $request->input('mission_id');
        $mission = $this->mission_tasks($mission_id);
        $role = $this->take_role();
        $location = 'Выполняющиеся_ИЗ';
        return view('missions.tasks_teacher.tasks_teacher', compact('role','location', 'mission'));
    }

    public function mission_tasks($mission_id)
    {
        $true_mission = null;
        $id = Auth::user()->id;
        $missions = DB::select('select missions.*, (select application_user.score from application_user where application_user.id_user = ? and application_user.id_mission = missions.id) as application_score from missions where missions.id = ? order by missions.date_start desc', [$id, $mission_id]);
        foreach ($missions as $mission) {
            $true_mission = $mission;
        }
        return $true_mission;
    }
}

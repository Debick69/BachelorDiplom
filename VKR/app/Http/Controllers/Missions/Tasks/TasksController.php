<?php

namespace App\Http\Controllers\Missions\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function missions_tasks(Request $request)
    {
        $mission_id = $request->input('mission_id');
        $mission = $this->mission_tasks($mission_id);
        $users = $this->users_tasks($mission_id);
        $role = $this->take_role();
        $location = 'Выполняющиеся_ИЗ';
        return view('missions.tasks.tasks', compact('role','location', 'mission', 'users'));
    }

    public function mission_tasks($mission_id)
    {
        $true_mission = null;
        $missions = DB::select('select missions.* from missions where missions.id = ? order by missions.date_start desc', [$mission_id]);
        foreach ($missions as $mission) {
            $true_mission = $mission;
        }
        return $true_mission;
    }

    public function users_tasks($mission_id)
    {
        $users = null;
        $users = DB::select('select report_user.*, (select users.name from users where users.id = report_user.id_user) as user_name, (select application_user.score from application_user where application_user.id_user = report_user.id_user and application_user.id_mission = report_user.id_mission) as application_score from report_user where report_user.id_mission = ?', [$mission_id]);
        return $users;
    }
}

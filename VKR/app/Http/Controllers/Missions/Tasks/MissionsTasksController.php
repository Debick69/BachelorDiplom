<?php

namespace App\Http\Controllers\Missions\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class MissionsTasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function take_missions_tasks()
    {
        $missions_tasks = null;
        $id = Auth::user()->id;
        $missions_tasks = DB::select('select * from missions where missions.date_start_mission <= NOW() and missions.date_end_mission >= NOW() and missions.id_vice_rector = ? order by missions.date_start_mission desc', [$id]);
        return $missions_tasks;
    }

    public function missions_missions_tasks()
    {
        $role = $this->take_role();
        $missions_tasks = $this->take_missions_tasks();
        $location = 'Выполняющиеся_ИЗ';
        return view('missions.tasks.missions_tasks', compact('role','location', 'missions_tasks'));
    }
}

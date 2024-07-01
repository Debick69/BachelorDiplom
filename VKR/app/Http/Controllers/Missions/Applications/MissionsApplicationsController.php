<?php

namespace App\Http\Controllers\Missions\Applications;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class MissionsApplicationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function take_missions_applications()
    {
        $missions_applications = null;
        $state_applications = "На рассмотрении";
        $state_answer = "Одобрено ректором";
        $id = Auth::user()->id;
        $missions_applications = DB::select('select *, (select count(*) from application_user where application_user.id_mission = missions.id and application_user.state = ?) as applications_count, (select count(*) from application_user where application_user.id_mission = missions.id and application_user.state = ?) as answer_count from missions where missions.date_start_application <= NOW() and missions.date_end_application >= NOW() and missions.id_vice_rector = ? order by missions.date_start_application desc', [$state_applications, $state_answer, $id]);
        return $missions_applications;
    }

    public function missions_missions_applications()
    {
        $role = $this->take_role();
        $missions_applications = $this->take_missions_applications();
        $location = 'Заявки';
        return view('missions.applications.missions_applications', compact('role','location', 'missions_applications'));
    }
}

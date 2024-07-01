<?php

namespace App\Http\Controllers\Missions\Approve;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class MissionsApproveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function take_missions_approve()
    {
        $missions_approve = null;
        $state_approve = "Одобрено";
        $state_answer = "Одобрено ректором";
        $id = Auth::user()->id;
        $missions_approve = DB::select('select *, (select count(*) from application_user where application_user.id_mission = missions.id and application_user.state = ?) as applications_count, (select count(*) from application_user where application_user.id_mission = missions.id and application_user.state = ?) as answer_count, (select users.name from users where users.id = missions.id_vice_rector) as name_vice_rector from missions where missions.date_start_application <= NOW() and missions.date_end_application >= NOW() order by missions.date_start_application desc', [$state_approve, $state_answer]);
        return $missions_approve;
    }

    public function missions_missions_approve()
    {
        $role = $this->take_role();
        $missions_approve = $this->take_missions_approve();
        $location = 'Утверждение';
        return view('missions.approve.missions_approve', compact('role','location', 'missions_approve'));
    }
}

<?php

namespace App\Http\Controllers\Missions;

use App\Http\Controllers\Controller;
use function redirect;
use function view;

class MissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function missions()
    {
        $role = $this->take_role();
        $location = 'Задания';
        return view('missions.missions', compact('role', 'location'));
    }

    public function remissions()
    {
        return redirect('/missions');
    }
}

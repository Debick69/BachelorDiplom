<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use function view;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function statistics()
    {
        $role = $this->take_role();
        $location = 'Статистика';
        return view('statistics.statistics', compact('role', 'location'));
    }

}

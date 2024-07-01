<?php

namespace App\Http\Controllers\Missions\Create;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class MissionsCreateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function missions_missions_create_open($mission, $faults_date, $fault_name, $fault_text, $fault_max_score, $fault_max_workers)
    {
        $role = $this->take_role();
        $location = 'Создание';
        return view('missions.create.missions_create', compact('role','location', 'mission', 'faults_date', 'fault_name', 'fault_text', 'fault_max_score', 'fault_max_workers'));
    }

    public function missions_missions_create()
    {
        $mission = $this->take_mission_create();
        $true_date = null;
        $dates = DB::select('select NOW() as date_now');
        foreach ($dates as $date)
        {
            $true_date = $date->date_now;
        }
        $faults_date = array
        (
            "fault_date_start_application" => false,
            "fault_date_end_application" => false,
            "fault_date_start_mission" => false,
            "fault_date_end_mission" => false,
            "fault_date_start_attestation" => false,
            "fault_date_end_attestation" => false,
            "fault_date_end" => false,
            "faults_num" => 0
        );
        $fault_name = false;
        $fault_text = false;
        $fault_max_score = false;
        $fault_max_workers = false;
        $mission->name = null;
        $mission->max_score = null;
        $mission->text = null;
        $mission->max_workers = null;
        $mission->date_start = $true_date;
        $mission->date_start_application = $true_date;
        $mission->date_end_application = $true_date;
        $mission->date_start_mission = $true_date;
        $mission->date_end_mission = $true_date;
        $mission->date_start_attestation = $true_date;
        $mission->date_end_attestation = $true_date;
        $mission->date_end = $true_date;
        $view = $this->missions_missions_create_open($mission, $faults_date, $fault_name, $fault_text, $fault_max_score, $fault_max_workers);
        return $view;
    }

    public function take_mission_create()
    {
        $true_mission = null;
        $missions = DB::select('select * from missions limit 1');
        foreach ($missions as $mission) {
            $true_mission = $mission;
        }
        return $true_mission;
    }

    public function back_to_date_DB($date)
    {
        $date_DB = explode("T", $date)[0] . " " . explode("T", $date)[1];
        return $date_DB;
    }

    public function date_to_int($date)
    {
        $expl = explode(" ", $date);
        $first_half = $expl[0];
        $second_half = $expl[1];

        $expl_first = explode("-", $first_half);
        $year = $expl_first[0];
        $month = $expl_first[1];
        $day = $expl_first[2];

        $expl_second = explode(":", $second_half);
        $hour = $expl_second[0];
        $minute = $expl_second[1];
        $second = $expl_second[2];

        $str = $year . $month . $day . $hour . $minute . $second;
        $int = intval($str);
        return $int;
    }

    public function missions_create_create(Request $request)
    {
        $mission_name = $request->input('mission_name');
        $mission_max_score = $request->input('mission_max_score');
        $mission_text = $request->input('mission_text');
        $mission_max_workers = $request->input('mission_max_workers');
        $mission_date_start = date("Y-m-d H:i:s");
        $mission_date_start_application = $this->back_to_date_DB($request->input('mission_date_start_application'));
        $mission_date_end_application = $this->back_to_date_DB($request->input('mission_date_end_application'));
        $mission_date_start_mission = $this->back_to_date_DB($request->input('mission_date_start_mission'));
        $mission_date_end_mission = $this->back_to_date_DB($request->input('mission_date_end_mission'));
        $mission_date_start_attestation = $this->back_to_date_DB($request->input('mission_date_start_attestation'));
        $mission_date_end_attestation = $this->back_to_date_DB($request->input('mission_date_end_attestation'));
        $mission_date_end = $this->back_to_date_DB($request->input('mission_date_end'));
        $faults_date = $this->check_date($mission_date_start, $mission_date_start_application, $mission_date_end_application, $mission_date_start_mission, $mission_date_end_mission, $mission_date_start_attestation, $mission_date_end_attestation, $mission_date_end);
        $fault_name = $this->check_name($mission_name);
        $fault_text = $this->check_text($mission_text);
        $fault_max_score = $this->check_max_score($mission_max_score);
        $fault_max_workers = $this->check_max_workers($mission_max_workers);
        if($faults_date["faults_num"] > 0 || $fault_name || $fault_text || $fault_max_score || $fault_max_workers)
        {
            $mission = $this->take_mission_create();
            $mission->name = $mission_name;
            $mission->max_score = $mission_max_score;
            $mission->text = $mission_text;
            $mission->max_workers = $mission_max_workers;
            $mission->date_start_application = $mission_date_start_application;
            $mission->date_end_application = $mission_date_end_application;
            $mission->date_start_mission = $mission_date_start_mission;
            $mission->date_end_mission = $mission_date_end_mission;
            $mission->date_start_attestation = $mission_date_start_attestation;
            $mission->date_end_attestation = $mission_date_end_attestation;
            $mission->date_end = $mission_date_end;
            $view = $this->missions_missions_create_open($mission, $faults_date, $fault_name, $fault_text, $fault_max_score, $fault_max_workers);
            return $view;
        }
        else
        {
            $this->missions_create_create_DB($mission_name, $mission_max_score, $mission_text, $mission_max_workers, $mission_date_start, $mission_date_start_application, $mission_date_end_application, $mission_date_start_mission, $mission_date_end_mission, $mission_date_start_attestation, $mission_date_end_attestation, $mission_date_end);
            $view = $this->server_answer_open();
            return $view;
        }
    }

    public function check_date($mission_date_start, $mission_date_start_application, $mission_date_end_application, $mission_date_start_mission, $mission_date_end_mission, $mission_date_start_attestation, $mission_date_end_attestation, $mission_date_end)
    {
        $faults = array
        (
            "fault_date_start_application" => false,
            "fault_date_end_application" => false,
            "fault_date_start_mission" => false,
            "fault_date_end_mission" => false,
            "fault_date_start_attestation" => false,
            "fault_date_end_attestation" => false,
            "fault_date_end" => false,
            "faults_num" => 0
        );
        $mission_date_start_int = $this->date_to_int($mission_date_start);
        $mission_date_start_application_int = $this->date_to_int($mission_date_start_application);
        $mission_date_end_application_int = $this->date_to_int($mission_date_end_application);
        $mission_date_start_mission_int = $this->date_to_int($mission_date_start_mission);
        $mission_date_end_mission_int = $this->date_to_int($mission_date_end_mission);
        $mission_date_start_attestation_int = $this->date_to_int($mission_date_start_attestation);
        $mission_date_end_attestation_int = $this->date_to_int($mission_date_end_attestation);
        $mission_date_end_int = $this->date_to_int($mission_date_end);
        if($mission_date_start_int > $mission_date_start_application_int || $mission_date_start_application_int > $mission_date_end_application_int)
        {
            $faults["fault_date_start_application"] = true;
            $faults["faults_num"] += 1;
        }
        if($mission_date_start_application_int > $mission_date_end_application_int || $mission_date_end_application_int > $mission_date_start_mission_int)
        {
            $faults["fault_date_end_application"] = true;
            $faults["faults_num"] += 1;
        }
        if($mission_date_end_application_int > $mission_date_start_mission_int || $mission_date_start_mission_int > $mission_date_end_mission_int)
        {
            $faults["fault_date_start_mission"] = true;
            $faults["faults_num"] += 1;
        }
        if($mission_date_start_mission_int > $mission_date_end_mission_int || $mission_date_end_mission_int > $mission_date_start_attestation_int)
        {
            $faults["fault_date_end_mission"] = true;
            $faults["faults_num"] += 1;
        }
        if($mission_date_end_mission_int > $mission_date_start_attestation_int || $mission_date_start_attestation_int > $mission_date_end_attestation_int)
        {
            $faults["fault_date_start_attestation"] = true;
            $faults["faults_num"] += 1;
        }
        if($mission_date_start_attestation_int > $mission_date_end_attestation_int || $mission_date_end_attestation_int > $mission_date_end_int)
        {
            $faults["fault_date_end_attestation"] = true;
            $faults["faults_num"] += 1;
        }
        if($mission_date_end_attestation_int > $mission_date_end_int)
        {
            $faults["fault_date_end"] = true;
            $faults["faults_num"] += 1;
        }
        return $faults;
    }

    public function check_name($name)
    {
        if($name == null)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_text($text)
    {
        if($text == null)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_max_score($max_score)
    {
        if($max_score == null || intval($max_score) > 2 || intval($max_score) <= 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_max_workers($max_workers)
    {
        if($max_workers == null || intval($max_workers) <= 0 )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function missions_create_create_DB($mission_name, $mission_max_score, $mission_text, $mission_max_workers, $mission_date_start, $mission_date_start_application, $mission_date_end_application, $mission_date_start_mission, $mission_date_end_mission, $mission_date_start_attestation, $mission_date_end_attestation, $mission_date_end)
    {
        $mission_id_vice_rector = Auth::user()->id;
        DB::insert('insert into missions (missions.name, missions.max_score, missions.id_vice_rector, missions.text, missions.max_workers, missions.date_start, missions.date_start_application, missions.date_end_application, missions.date_start_mission, missions.date_end_mission, missions.date_start_attestation, missions.date_end_attestation, missions.date_end) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$mission_name, $mission_max_score, $mission_id_vice_rector, $mission_text, $mission_max_workers, $mission_date_start, $mission_date_start_application, $mission_date_end_application, $mission_date_start_mission, $mission_date_end_mission, $mission_date_start_attestation, $mission_date_end_attestation, $mission_date_end]);
        $this->add_notification($mission_id_vice_rector, "Индивидуальное задание создано", "Новое!");
        return 0;
    }

    public function server_answer_open()
    {
        $role = $this->take_role();
        $location = 'Создание';
        return view('missions.create.server_answer', compact('role','location'));
    }
}

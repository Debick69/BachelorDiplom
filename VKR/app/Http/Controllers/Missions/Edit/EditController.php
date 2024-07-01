<?php

namespace App\Http\Controllers\Missions\Edit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mission_edit($mission_id)
    {
        $true_mission = null;
        $missions = DB::select('select * from missions where missions.id = ? order by missions.date_start desc', [$mission_id]);
        foreach ($missions as $mission) {
            $true_mission = $mission;
        }
        return $true_mission;
    }

    public function missions_edit_open($edit_type, $mission, $faults_date, $fault_name, $fault_text, $fault_max_score, $fault_max_workers)
    {
        $role = $this->take_role();
        $location = 'Редактирование';
        return view('missions.edit.edit', compact('role','location', 'mission', 'edit_type', 'faults_date', 'fault_name', 'fault_text', 'fault_max_score', 'fault_max_workers'));
    }

    public function missions_edit(Request $request)
    {
        $edit_type = $request->input('edit_type');
        $mission_id = $request->input('mission_id');
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
        $mission = $this->mission_edit($mission_id);
        $view = $this->missions_edit_open($edit_type, $mission, $faults_date, $fault_name, $fault_text, $fault_max_score, $fault_max_workers);
        return $view;
    }

    public function back_to_date_DB($date)
    {
        $date_DB = explode("T", $date)[0] . " " . explode("T", $date)[1];
        return $date_DB;
    }

    public function missions_edit_edit(Request $request)
    {
        $edit_type = $request->input('edit_type');
        $mission_id = $request->input('mission_id');
        $mission_name = $request->input('mission_name');
        $mission_max_score = $request->input('mission_max_score');
        $mission_text = $request->input('mission_text');
        $mission_max_workers = $request->input('mission_max_workers');
        $mission_date_start = $this->back_to_date_DB($request->input('mission_date_start'));
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
        $fault_max_score = $this->check_max_score($mission_max_score, $mission_id);
        $fault_max_workers = $this->check_max_workers($mission_max_workers, $mission_id);
        if($faults_date["faults_num"] > 0 || $fault_name || $fault_text || $fault_max_score || $fault_max_workers)
        {
            $mission = $this->mission_edit($mission_id);
            $mission->name = $mission_name;
            $mission->max_score = $mission_max_score;
            $mission->text = $mission_text;
            $mission->max_workers = $mission_max_workers;
            $mission->date_start = $mission_date_start;
            $mission->date_start_application = $mission_date_start_application;
            $mission->date_end_application = $mission_date_end_application;
            $mission->date_start_mission = $mission_date_start_mission;
            $mission->date_end_mission = $mission_date_end_mission;
            $mission->date_start_attestation = $mission_date_start_attestation;
            $mission->date_end_attestation = $mission_date_end_attestation;
            $mission->date_end = $mission_date_end;
            $view = $this->missions_edit_open($edit_type, $mission, $faults_date, $fault_name, $fault_text, $fault_max_score, $fault_max_workers);
            return $view;
        }
        else
        {
            $this->missions_edit_edit_DB($edit_type, $mission_id, $mission_name, $mission_max_score, $mission_text, $mission_max_workers, $mission_date_start, $mission_date_start_application, $mission_date_end_application, $mission_date_start_mission, $mission_date_end_mission, $mission_date_start_attestation, $mission_date_end_attestation, $mission_date_end);
            $view = $this->server_answer_open($edit_type);
            return $view;
        }
    }

    public function server_answer_open($edit_type)
    {
        $role = $this->take_role();
        $location = 'Редактирование';
        return view('missions.edit.server_answer', compact('role','location', 'edit_type'));
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

    public function missions_edit_edit_DB($edit_type, $mission_id, $mission_name, $mission_max_score, $mission_text, $mission_max_workers, $mission_date_start, $mission_date_start_application, $mission_date_end_application, $mission_date_start_mission, $mission_date_end_mission, $mission_date_start_attestation, $mission_date_end_attestation, $mission_date_end)
    {
        switch ($edit_type)
        {
            case("Не выложенные задания"):
                DB::update('update missions set missions.name = ?, missions.max_score = ?, missions.text = ?, missions.max_workers = ?, missions.date_start_application = ?, missions.date_end_application = ?, missions.date_start_mission = ?, missions.date_end_mission = ?, missions.date_start_attestation = ?, missions.date_end_attestation = ?, missions.date_end = ? where missions.id = ?', [$mission_name, $mission_max_score, $mission_text, $mission_max_workers, $mission_date_start_application, $mission_date_end_application, $mission_date_start_mission, $mission_date_end_mission, $mission_date_start_attestation, $mission_date_end_attestation, $mission_date_end, $mission_id]);
                break;
            case("Задания на приеме заявок"):
                DB::update('update missions set missions.name = ?, missions.text = ?, missions.max_workers = ?, missions.date_end_application = ?, missions.date_start_mission = ?, missions.date_end_mission = ?, missions.date_start_attestation = ?, missions.date_end_attestation = ?, missions.date_end = ? where missions.id = ?', [$mission_name, $mission_text, $mission_max_workers, $mission_date_end_application, $mission_date_start_mission, $mission_date_end_mission, $mission_date_start_attestation, $mission_date_end_attestation, $mission_date_end, $mission_id]);
                break;
            case("Задания в стадии выполнения"):
                DB::update('update missions set missions.text = ?, missions.date_end_mission = ?, missions.date_start_attestation = ?, missions.date_end_attestation = ?, missions.date_end = ? where missions.id = ?', [$mission_text, $mission_date_end_mission, $mission_date_start_attestation, $mission_date_end_attestation, $mission_date_end, $mission_id]);
                break;
            case("Задания в стадии аттестации"):
                DB::update('update missions set missions.date_end_attestation = ?, missions.date_end = ? where missions.id = ?', [$mission_date_end_attestation, $mission_date_end, $mission_id]);
                break;
            default:
                break;
        }

        $true_id_vice_rectors = Auth::user()->id;
        $this->add_notification($true_id_vice_rectors, "Индивидуальное задание изменено", "Новое!");

        return 0;
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

    public function check_max_score($max_score, $mission_id)
    {
        if($max_score == null || intval($max_score) > 2 || intval($max_score) <= 0 || $this->check_score_DB($max_score, $mission_id))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_max_workers($max_workers, $mission_id)
    {
        if($max_workers == null || intval($max_workers) <= 0 || $this->check_workers_DB($max_workers, $mission_id))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_workers_DB($max_workers, $mission_id)
    {
        $count = 0;
        $state_answer1 = "Одобрено ректором";
        $state_answer2 = "Ожидает ответа";
        $state_answer3 = "Одобрено";
        $aggree_applications = DB::select('select count(*) as aggree_applications from application_user where application_user.id_mission = ? and (application_user.state = ? or application_user.state = ? or application_user.state = ?)', [$mission_id, $state_answer1, $state_answer2, $state_answer3]);
        foreach ($aggree_applications as $aggree_application)
        {
            $count = $aggree_application->aggree_applications;
        }
        if(intval($max_workers) < intval($count))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function check_score_DB($max_score, $mission_id)
    {
        $max = 0;
        $max_scores_DB = DB::select('select max(application_user.score) as max_score from application_user where application_user.id_mission = ?', [$mission_id]);
        foreach ($max_scores_DB as $max_score_DB)
        {
            $max = $max_score_DB->max_score;
        }
        if(intval($max_score) < intval($max))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

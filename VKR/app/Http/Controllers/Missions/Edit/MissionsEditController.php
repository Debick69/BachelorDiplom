<?php

namespace App\Http\Controllers\Missions\Edit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class MissionsEditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function take_missions_edit($edit_type)
    {
        $missions_edit = null;
        $id = Auth::user()->id;
        switch ($edit_type)
        {
            case("Не выложенные задания"):
                $missions_edit = DB::select('select * from missions where missions.id_vice_rector = ? and missions.date_start <= NOW() and missions.date_start_application >= NOW() order by missions.date_start desc', [$id]);
                break;
            case("Задания на приеме заявок"):
                $missions_edit = DB::select('select * from missions where missions.id_vice_rector = ? and missions.date_start_application <= NOW() and missions.date_end_application >= NOW() order by missions.date_start_application desc', [$id]);
                break;
            case("Задания в стадии выполнения"):
                $missions_edit = DB::select('select * from missions where missions.id_vice_rector = ? and missions.date_start_mission <= NOW() and missions.date_end_mission >= NOW() order by missions.date_start_mission desc', [$id]);
                break;
            case("Задания в стадии аттестации"):
                $missions_edit = DB::select('select * from missions where missions.id_vice_rector = ? and missions.date_start_attestation <= NOW() and missions.date_end_attestation >= NOW() order by missions.date_start_attestation desc', [$id]);
                break;
            case("Не актуальные задания"):
                $missions_edit = DB::select('select * from missions where missions.id_vice_rector = ? and missions.date_end <= NOW() order by missions.date_end desc', [$id]);
                break;
            default:
                break;
        }
        return $missions_edit;
    }

    public function missions_missions_edit_open($edit_type)
    {
        $role = $this->take_role();
        $missions_edit = $this->take_missions_edit($edit_type);
        $location = 'Редактирование';
        return view('missions.edit.missions_edit', compact('role','location', 'missions_edit', 'edit_type'));
    }

    public function missions_missions_edit()
    {
        $edit_type = "Не выложенные задания";
        $view = $this->missions_missions_edit_open($edit_type);
        return $view;
    }

    public function missions_missions_edit_post(Request $request)
    {
        $edit_type = $request->input('edit_type');
        $view = $this->missions_missions_edit_open($edit_type);
        return $view;
    }
}

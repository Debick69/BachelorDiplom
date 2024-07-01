<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function take_role()
    {
        $role = null;
        $id = Auth::user()->id;
        $roles = DB::select('select roles.name from users, roles where users.id_roles = roles.id and users.id = ?', [$id]);
        foreach ($roles as $rol){
            $role = $rol->name;
        }
        return $role;
    }

    public function add_notification($id_user, $text, $title)
    {
        $true_id_notification = 0;
        $id_notification = DB::select('select * from notification order by notification.id desc limit 1');
        foreach ($id_notification as $id_notif) {
            $true_id_notification = $id_notif->id;
        }
        $true_id_notification += 1;
        DB::insert('insert into notification (notification.id, notification.title, notification.text, notification.datetime) VALUES (?, ?, ?, NOW())', [$true_id_notification, $title, $text]);
        DB::insert('insert into user_notification (user_notification.id_notification, user_notification.id_user) VALUES (?, ?)', [$true_id_notification, $id_user]);
    }
}

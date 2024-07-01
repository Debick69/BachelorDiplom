<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function view;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function take_notifications()
    {
        $notifications = null;
        $id = Auth::user()->id;
        $notifications = DB::select('select notification.title, notification.text, notification.datetime from user_notification, notification where user_notification.id_notification = notification.id and user_notification.id_user = ? order by notification.datetime desc', [$id]);
        return $notifications;
    }

    public function notifications()
    {
        $role = $this->take_role();
        $notifications = $this->take_notifications();
        $location = 'Уведомления';
        return view('notifications.notifications', compact('role', 'location', 'notifications'));
    }

}

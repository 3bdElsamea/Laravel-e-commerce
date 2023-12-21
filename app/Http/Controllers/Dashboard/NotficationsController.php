<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotficationsController extends Controller
{
    //index
    public function index()
    {
        $notifications =Notification::paginate(25);

//        dd($notifications);
        return view('notifications',compact('notifications'));
    }
}

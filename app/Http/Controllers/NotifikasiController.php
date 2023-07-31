<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    public function read(Request $request)
    {
        auth()->user()->unreadNotifications->where('id', $request->input('id'))->markAsRead();

        return back();
    }

    public function delete(Request $request)
    {
        auth()->user()->notifications->where('id', $request->input('id'))->delete();

        return back();
    }
}

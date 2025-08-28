<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class DashboardController extends Controller
{

    public function index(Request $request)
    {

        $year = 1;

        return view('admin.dashboard.index', [
            'year'            => $year
        ]);
    }

}

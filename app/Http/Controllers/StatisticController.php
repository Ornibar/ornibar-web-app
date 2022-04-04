<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatisticController extends Controller
{

    /**
     * Display the statistic view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('statistic.index');
    }

}

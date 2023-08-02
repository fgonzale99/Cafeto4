<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function customerByState()
    {
        $data =  \App\Models\Customer::groupBy('state')->select('state', DB::raw('count(*) as total'))->get();

        $response['data'] = $data;
        $response['success'] = true;

        return $response;
    }

    public function processByState()
    {
        $response =  \App\Models\Process::groupBy('state')->select('state', DB::raw('count(*) as total'))->get();

        return $response;
    }

    public function reviewByState()
    {
        $response =  \App\Models\ProjectReview::groupBy('state')->select('state', DB::raw('count(*) as total'))->get();

        return $response;
    }


    public function reviewByMonth()
    {
        $response =  \App\Models\ProjectReview::groupBy('state')->select('state', DB::raw('count(*) as total'))->get();

        return $response;
    }


}

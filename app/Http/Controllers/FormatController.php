<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormatController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
      $elements = \App\Models\Format::orderBy('id','DESC')->paginate(20);
      return view('format.list', compact('elements'));
    }

    public function new()
    {
       return view('format.new');
    }

}

<?php

namespace App\Http\Controllers;

class AppController extends Controller
{
    /**
     * Return the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('app');
    }
}

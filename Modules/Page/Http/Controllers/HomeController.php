<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Contracts\Session\Session;

class HomeController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.home.index');
    }
}

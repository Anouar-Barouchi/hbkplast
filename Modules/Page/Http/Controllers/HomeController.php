<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Modules\Category\Entities\Category;

class HomeController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('files')
                            ->limit(20)
                            ->get();
        // dd($categories);
        return view('public.home.index', compact('categories'));
    }
}

<?php

namespace Modules\Slider\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Slider\Entities\MobileSlider;

class MobileSliderController extends Controller
{
    use HasCrudActions;

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $slider = MobileSlider::first();
        return view('slider::admin.mobile.edit', compact('slider'));
    }

    public function store()
    {
        $entity = MobileSlider::first();

        

        $entity->update(
            request()->all()
        );

        return redirect()->back();
    }


}

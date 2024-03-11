<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Modules\Admin\Traits\HasCrudActions;
use Modules\User\Http\Requests\SaveUserRequest;
use Cartalyst\Sentinel\Laravel\Facades\Activation;

class UserController
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'user::users.user';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'user::admin.users';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveUserRequest::class;

    /**
     * Store a newly created resource in storage.
     *
     * @param \Modules\User\Http\Requests\SaveUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveUserRequest $request)
    {
        $request->merge(['password' => bcrypt($request->password)]);

        $user = User::create($request->all());

        $user->roles()->attach($request->roles);

        Activation::complete($user, Activation::create($user)->code);

        return redirect()->route('admin.users.index')
            ->withSuccess(trans('admin::messages.resource_saved', ['resource' => trans('user::users.user')]));
    }

    public function index_drivers(Request $request)
    {
        return view('user::admin.users.drivers');
    }

    public function getNotify(Request $request)
    {
        return view('user::admin.users.notify');
    }

    public function notify(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);
        notify_users($request->title, $request->body);
        // dd(1);
        return redirect()->route('admin.users.notifications')
            ->withSuccess(trans('admin::messages.resource_sent', ['resource' => trans('user::users.notification')]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param \Modules\User\Http\Requests\SaveUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, SaveUserRequest $request)
    {
        $user = User::findOrFail($id);

        if (is_null($request->password)) {
            unset($request['password']);
        } else {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        $user->update($request->all());

        $user->roles()->sync($request->roles);

        if (! Activation::completed($user) && $request->activated === '1') {
            Activation::complete($user, Activation::create($user)->code);
        }

        if (Activation::completed($user) && $request->activated === '0') {
            Activation::remove($user);
        }

        return redirect()->route('admin.users.index')
            ->withSuccess(trans('admin::messages.resource_saved', ['resource' => trans('user::users.user')]));
    }
}

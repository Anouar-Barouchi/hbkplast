<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\User\Contracts\Authentication;
use Modules\User\Entities\Role;
use Modules\User\Entities\User;
use Modules\User\Events\CustomerRegistered;

class ApiAuthController extends Controller
{

    /**
     * The Authentication instance.
     *
     * @var \Modules\User\Contracts\Authentication
     */
    protected $auth;


    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('user::index');
    }

    function getUser(Request $request) {
        return Auth::guard('api')->user();
    }

    function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'     => ['required', 'email'],
            'password'  => ['required'],
        ]); 
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        

        $credentials = [
            'email'     => $request->email,
            'password'  => $request->password,
        ];

        
        if (!Auth::attempt($credentials)) {
            return response('Invalid Credentials');
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token,  
        ]);
    }

    function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['required'],
            'first_name'    => ['required'],
            'last_name'     => ['required'],
            'phone'         => ['required'],
        ]); 
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = $this->auth->registerAndActivate($request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'password',
        ]));

        $this->assignCustomerRole($user);

        event(new CustomerRegistered($user));
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        return response()->json([
            'status' => true,
            'msg'    => 'Registred With success',
            'user'   => $user,
            'token'  => $token
        ]);
    }

    protected function assignCustomerRole($user)
    {
        $role = Role::findOrNew(setting('customer_role'));

        if ($role->exists) {
            $this->auth->assignRole($user, $role);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}

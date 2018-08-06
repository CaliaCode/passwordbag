<?php

namespace App\Http\Controllers\Admin;

// Framework
use App\Http\Requests;
use App\Http\Controllers\Controller;

// Libraries
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Yajra\Datatables\Facades\Datatables;

// Requests
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Requests\Admin\User\UpdateProfileRequest;
use App\Http\Requests\Admin\User\UpdatePasswordRequest;

// Services
use App\Services\UserService;

// Models
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display the PasswordBag Home Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('admin');
    }

    /**
     * Process DataTables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allUsers()
    {
        $query = User::select('users.id', 'users.name', 'users.email', 'users.status', 'user_infos.first_name', 'user_infos.last_name')
            ->leftJoin('user_infos', 'users.id','=','user_infos.user_id')
            ->where('users.id', '<>', Auth::id());

        return Datatables::of($query)
            ->addColumn('actions', function ($user) {
                return '<div class="app_datatable-actions">' .
                            '<a href="#" class="app_actions-user btn btn-xs btn-default" data-id="' .$user->id. '" data-action-type="view" data-from="table"><i class="fa fa-eye"></i></a>' .
                            '<a href="#" class="app_actions-user btn btn-xs btn-default" data-id="' .$user->id. '" data-action-type="update" data-from="table" ><i class="fa fa-edit"></i></a>' .
                            '<a href="#" class="app_actions-user btn btn-xs btn-default" data-id="' .$user->id. '" data-action-type="delete" data-from="table" ><i class="fa fa-trash"></i></a>' .
                        '</div>';
            })
            ->addColumn('full_name', function ($user) {
                return $user->userInfo->first_name . ' ' . $user->userInfo->last_name;
            })
            ->editColumn('status', function($user){

                return '<span class="label label-' . (($user->status === 1) ? 'success': 'danger') . '">' . (($user->status === 1) ? 'ACTIVE': 'INACTIVE') . '</span>';

            })
            ->make(true);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rawProjects = Project::all();

        $projects = [];
        
        foreach ($rawProjects as $project){
            $projects[$project['id']] = $project['name'];
        }
        
        return view('admin.users.create', compact('projects'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  CreateUserRequest  $request
     * @param  UserService $userService
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request, UserService $userService)
    {

        $data = [];
        
        $data['user'] = $request->only('name', 'email', 'password', 'status');
        $data['userInfo'] = $request->only('first_name', 'last_name', 'avatar');
        $data['role']['name'] = $request->input('role');
        $data['projects'] = $request->input('projects');  
 
        // Check if "avatar" exists and stores it
        if($request->hasFile('avatar') && $request->file('avatar')->isValid()){

            $path = $request->file('avatar')->store('uploads/avatars', 'public');

            Image::make('public/' . $path)->fit(100, 100)->save();

            $data['userInfo']['avatar'] = $path;


        }else{
            unset($data['userInfo']['avatar']);
        }        
        
        // Create the User
        $userService->createUser($data);

        return response('User Created.');
    }

    /**
     * Display the specified User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = User::with(['userInfo', 'roles', 'assignedProjects'])->findOrFail($id);

        return view('admin.users.view', compact('user'));

    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::with(['userInfo', 'roles'])->find($id);

        $assignedProjects = null;

        if($user->hasRole('employer')){

            $tempAssignedProjects = $user->assignedProjects()->get();

            foreach ($tempAssignedProjects as $project){
                $assignedProjects[] = $project->id;
            }

        }
        
        $rawProjects = Project::all();

        $projects = [];

        foreach ($rawProjects as $project){
            $projects[$project->id] = $project['name'];
        }

        return view('admin.users.edit', compact('user', 'projects', 'assignedProjects'));

    }

    /**
     * Update the specified User in storage.
     *
     * @param UpdateUserRequest  $request
     * @param UserService $userService
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, UserService $userService, $id)
    {
        $data = [];

        $data['user'] = $request->only('name', 'email', 'status');
        $data['userInfo'] = $request->only('first_name', 'last_name', 'avatar');
        $data['role']['name'] = $request->input('role');
        $data['projects'] = $request->input('projects');

        // Check if "avatar" exists and stores it
        if($request->hasFile('avatar') && $request->file('avatar')->isValid()){

            $path = $request->file('avatar')->store('uploads/avatars', 'public');

            Image::make('public/' . $path)->fit(100, 100)->save();

            $data['userInfo']['avatar'] = $path;


        }else{
            unset($data['userInfo']['avatar']);
        }

        // Create the User
        $userService->updateUser($id, $data);

        return response('User updated.');
    }

    /**
     * Remove the specified User from storage.
     *
     * @param UserService $userService
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserService $userService, $id)
    {
        if($id == Auth::id()){
            return response('You cannot delete yourself.');
        }
        
        // Delete the User
        $userService->deleteUser($id);

        return response('User successfully deleted.');
    }

    public function profileEdit($id){

        if(Gate::denies('update-profile', $id)){
            abort(403, 'You can update only your Account.');
        }

        $user = User::with(['userInfo'])->findOrFail($id);

        return view('admin.users.profile-edit', compact('user'));

        
    }

    public function profileUpdate(UpdateProfileRequest $request, UserService $userService, $id){

        $data = [];

        $data['user'] = $request->only('name', 'email');
        $data['userInfo'] = $request->only('first_name', 'last_name', 'avatar');

        // Check if "avatar" exists and stores it
        if($request->hasFile('avatar') && $request->file('avatar')->isValid()){

            $path = $request->file('avatar')->store('uploads/avatars', 'public');

            Image::make('public/' . $path)->fit(100, 100)->save();

            $data['userInfo']['avatar'] = $path;


        }else{
            unset($data['userInfo']['avatar']);
        }

        // Create the User
        $userService->updateProfile($id, $data);

        return response('Profile updated.');

    }
    
    public function passwordEdit($id){

        if(Gate::denies('update-profile', $id)){
            abort(403, 'You can update only your Password.');
        }

        $user = User::with(['userInfo'])->findOrFail($id);

        return view('admin.users.password-edit', compact('user'));
        
    }

    public function passwordUpdate(UpdatePasswordRequest $request, $id){

        $request->user()->fill([
            'password' => Hash::make($request->new_password)
        ])->save();

        return response('Password Changed.');

    }
}

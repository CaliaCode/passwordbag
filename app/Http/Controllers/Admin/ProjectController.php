<?php

namespace App\Http\Controllers\Admin;

// Framework
use App\Models\Client;
use App\Http\Requests;
use App\Http\Controllers\Controller;

// Libraries
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Facades\Datatables;

// Models
use App\Models\Project;

// Requests
use App\Http\Requests\Admin\Project\CreateProjectRequest;
use App\Http\Requests\Admin\Project\UpdateProjectRequest;

class ProjectController extends Controller
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
     * Display a list of all Projects related to a Client.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientProjects($id)
    {
        $client = Client::with('user')->find($id);

//        return view('admin.projects.client-projects', compact('client'));
        return response()->json($client->toArray());
    }

    /**
     * Process DataTables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allProjects($client = null)
    {
        if(Auth::user()->hasRole('employer')){
            
            $assignedProjects = [];
            
            foreach (Auth::user()->assignedProjects()->get() as $project){
                $assignedProjects[] = $project->id;
            }

            $query = Project::whereIn('projects.id', $assignedProjects)->select('projects.id', 'projects.name', 'projects.description', 'clients.company',
                'users.name as user_name')
                ->leftJoin('clients', 'projects.client_id', '=', 'clients.id')
                ->leftJoin('users', 'projects.user_id', '=', 'users.id');
        }else{
            if($client){
                $query = Project::where('projects.client_id', $client)->select('projects.id', 'projects.name', 'projects.description', 'clients.company',
                    'users.name as user_name')
                    ->leftJoin('clients', 'projects.client_id', '=', 'clients.id')
                    ->leftJoin('users', 'projects.user_id', '=', 'users.id');
            }else {
                $query = Project::select('projects.id', 'projects.name', 'projects.description', 'clients.company',
                    'users.name as user_name')
                    ->leftJoin('clients', 'projects.client_id', '=', 'clients.id')
                    ->leftJoin('users', 'projects.user_id', '=', 'users.id');
            }
        }        

        return Datatables::of($query)
            ->addColumn('actions', function ($project) {


                $projectActions = '<div class="app_datatable-actions">' .
                    '<a href="#" class="app_actions-project btn btn-xs btn-default" data-id="' . $project->id . '" data-action-type="view-related" data-from="table"><i class="fa fa-key"></i></a>' .
                    '<a href="#" class="app_actions-project btn btn-xs btn-default" data-id="' . $project->id . '" data-action-type="view" data-from="table"><i class="fa fa-eye"></i></a>';

                if(!Auth::user()->hasRole('employer')){
                    $projectActions .= '<a href="#" class="app_actions-project btn btn-xs btn-default" data-id="' . $project->id . '" data-action-type="update" data-from="table" ><i class="fa fa-edit"></i></a>' .
                        '<a href="#" class="app_actions-project btn btn-xs btn-default" data-id="' . $project->id . '" data-action-type="delete" data-from="table" ><i class="fa fa-trash"></i></a>' .
                        '</div>';
                }

                return $projectActions;
            })
            ->editColumn('description', function($project){
                return trim(substr($project->description, 0, 60)) . '...';
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new Project.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->authorize('create', Project::class);
        
        $clients = Client::select('id', 'company')->get()->toArray();

        $clientsList = [];

        foreach($clients as $client){
            $clientsList[$client['id']] = $client['company'];
        }

       $clients = $clientsList;

        return view('admin.projects.create', compact('clients'));

    }

    /**
     * Store a newly created Project in storage.
     *
     * @param  \App\Http\Requests\Admin\Project\CreateProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProjectRequest $request)
    {

        $user = $request->user();

        $project = $user->projects()->create($request->only('name', 'description'));

        if($clientId = $request->input('client')){

            $project->client()->associate(Client::find($clientId))->save();

        }

        return response('Project successfully created.');

    }

    /**
     * Display the specified Project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {

        $this->authorize('view', $project);
        
        $project->load('user', 'client');

        return view('admin.projects.view', compact('project'));

    }

    /**
     * Show the form for editing the specified Project.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        
        $project->load(['client']);

        $clients = Client::select('id', 'company')->get()->toArray();

        $clientsList = [];

        foreach($clients as $client){
            $clientsList[$client['id']] = $client['company'];
        }

        $clients = $clientsList;

        return view('admin.projects.edit', compact('project', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\Project\UpdateProjectRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        $this->authorize('update', $project);

        $project->update($request->only('name', 'description'));
       
        if($clientId = $request->input('client')){
            $project->client()->associate(Client::find($clientId))->save();
        }else{
            $project->client()->dissociate()->save();
        }

        return response('Project Successfully updated!');
    }

    /**
     * Remove the specified Project from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        $this->authorize('delete', $project);

        $project->delete();

        return response('Project successfully deleted.');

    }
}

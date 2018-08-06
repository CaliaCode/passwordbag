<?php

namespace App\Http\Controllers\Admin;
// Framework
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

// Libraries
use Yajra\Datatables\Facades\Datatables;

// Models
use App\Models\Client;

// Services
use App\Services\ClientService;

// Requests
use App\Http\Requests\Admin\Client\CreateClientRequest;
use App\Http\Requests\Admin\Client\UpdateClientRequest;

class ClientController extends Controller
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
    public function allClients()
    {
        $query = Client::select('clients.id', 'clients.company', 'clients.email', 'clients.phone', 'users.name')
            ->leftJoin('users', 'clients.user_id','=','users.id');

        return Datatables::of($query)
            ->addColumn('actions', function ($client) {
                return '<div class="app_datatable-actions">' .
                '<a href="#" class="app_actions-client btn btn-xs btn-default" data-id="' . $client->id . '" data-action-type="view-related" data-from="table"><i class="fa fa-tasks"></i></a>' .
                '<a href="#" class="app_actions-client btn btn-xs btn-default" data-id="' . $client->id . '" data-action-type="view" data-from="table"><i class="fa fa-eye"></i></a>' .
                '<a href="#" class="app_actions-client btn btn-xs btn-default" data-id="' . $client->id . '" data-action-type="update" data-from="table" ><i class="fa fa-edit"></i></a>' .
                '<a href="#" class="app_actions-client btn btn-xs btn-default" data-id="' . $client->id . '" data-action-type="delete" data-from="table" ><i class="fa fa-trash"></i></a>' .
                '</div>';
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new Client.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created Client in storage.
     *
     * @param  \App\Http\Requests\Admin\Client\CreateClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClientRequest $request, ClientService $clientService)
    {
        $clientService->createClient($request->all());

        return response('Client successfully created.');
    }

    /**
     * Display the specified Client.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $client = Client::with(['user'])->find($id);

        return view('admin.clients.view', compact('client'));
    }

    /**
     * Show the form for editing the specified Client.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::findOrFail($id);

        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified Client in storage.
     *
     * @param  \App\Http\Requests\Admin\Client\UpdateClientRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, $id)
    {

        Client::where('id', $id)->update($request->except(['_method', '_token']));

        return response('Client successfully updated.');

    }

    /**
     * Remove the specified Client from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::destroy((int) $id);

        return response('Client successfully deleted.');
    }
}

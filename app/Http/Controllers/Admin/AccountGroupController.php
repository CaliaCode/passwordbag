<?php

namespace App\Http\Controllers\Admin;

// Framework
use App\Mail\SendAccountGroup;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

// Requests
use App\Http\Requests\Admin\AccountGroup\CreateAccountGroupRequest;

// Models
use App\Models\AccountGroup;
use App\Models\Category;
use App\Models\Project;

// Email
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AccountGroupController extends Controller
{
    /**
     * Require all the AccountGroups with related data.
     *
     * @return \Illuminate\Http\Response
     */
    public function all($id = null)
    {

        if(Auth::user()->hasRole('employer')){
            $projects = Auth::user()->assignedProjects()
                ->orderBy('updated_at', 'desc')
                ->get();
        }else{
            $projects = Project::select('id', 'name')
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        $categories = Category::select('id', 'name')->get();

        if($id){
            
            if(Auth::user()->hasRole('employer') && Gate::denies('access-project', $id)){
                abort('403', 'You are not allowed to access or modify the accounts of this project.');
            }
            
            $project = $id;
            
            $accountGroups = AccountGroup::with(['category', 'accounts' => function ($query) {
                    $query->orderBy('position', 'asc');
                }])
//                ->select('id', 'title')
                ->orderBy('updated_at', 'desc')
                ->where('project_id', $id)
                ->get();
        }else {
            $project = $projects[0]->id;

            $accountGroups = AccountGroup::with(['category', 'accounts' => function ($query) {
                    $query->orderBy('position', 'asc');
                }])
//                ->select('id', 'title')
                ->orderBy('updated_at', 'desc')
                ->where('project_id', $project)
                ->get();
        }
        
        return response()->json(compact('project', 'projects', 'categories', 'accountGroups'));
    }

    /**
     * Store or Update an AccountGroup.
     *
     * @param  \App\Http\Requests\Admin\AccountGroup\CreateAccountGroupRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(CreateAccountGroupRequest $request)
    {
        if($request->has('id')){            
            if(Auth::user()->hasRole('employer') && Gate::denies('save-account_group', $request->input('id'))){
                abort('403', 'You are not allowed to modify this Account Group.');
            }
            
            AccountGroup::where('id', $request->input('id'))->update(['title' => $request->input('title')]);

            $accountGroup = AccountGroup::find($request->input('id'));
        }else{
            // Retrieve related Project to the AccountGroup
            $project = Project::find($request->input('project'));

            $accountGroup = $project->accountGroups()->create(['title' => $request->input('title')]);
        }

        // Associate Category to the AccountGroup if present
        if($request->has('category')){
            $category = Category::find($request->input('category'));

            $accountGroup->category()->associate($category)->save();
        }else{
            $accountGroup->category()->dissociate()->save();
        }

        $accountsToSave = [];

        foreach($request->input('accounts') as $account){
            if($account['value_type'] === 'password'){
                $account['value'] = encrypt($account['value']);
            }

            if(array_key_exists('id', $account)){
                $id = $account['id'];

                $accountsToSave[] = $id;

                unset($account['id']);

                Account::where('id', $id)->update($account);
            }else{

                $newAccount = $accountGroup->accounts()->create($account);

                $accountsToSave[] = $newAccount->id;

            }
        }

        Account::where('account_group_id', $accountGroup->id)->whereNotIn('id', $accountsToSave)->delete();

        $accountGroup->load(['category', 'accounts' => function ($query) {
            $query->orderBy('position', 'asc');
        }]);

        return response()->json($accountGroup->toArray());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(AccountGroup::destroy($id)){
            return response('Account Group successfully deleted.');
        }else{
            return response('Account Group not deleted.');
        }
    }

    /**
     * Send the Account Group to a given Mail.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request){

        Validator::make($request->all(),
            ['email' => 'bail|required|email|max:255'],
            ['email.required'    => 'Email is required.',
             'email.email'       => 'Must be a valid Email.'])->validate();

        $accountGroup = AccountGroup::with(['accounts', 'category'])
                                      ->find($request->account_group_id);

        Mail::to($request->email)->send(new SendAccountGroup($accountGroup));

        return response('Account Group sent.');
    }
}

<?php

namespace App\Repositories;

// Framework
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\User;

class UserRepository{

    /**
     * @var User
     */
    private $user;

    /**
     * UserRepository constructor.
     * 
     * @param User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Retrieve User
     *
     * @param int $id
     * @return User
     */
    public function get($id)
    {
        return $this->user->findOrFail($id);
    }

    /**
     * Create User
     *
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $data['password'] = bcrypt($data['password']);

        return $this->user->create($data);
    }

    /**
     * Update User
     *
     * @param array $data
     * @return User
     */
    public function update($id, array $data)
    {
        $user = $this->get($id);

        $user->update($data);

        return $user;

    }

    /**
     * Delete User
     *
     * @param $id
     * @return string $avatarPath
     */
    public function delete($id)
    {
        $user = $this->get($id);

        $firstAdmin = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->first();

        Client::where('user_id', $id)->update(['user_id' => $firstAdmin->id]);
        
        Project::where('user_id', $id)->update(['user_id' => $firstAdmin->id]);
        
        $avatarPath = $user->userInfo->avatar;

        if($avatarPath == 'uploads/avatars/avatar.png'){
            $avatarPath = false;
        }

        $user->delete();

        return $avatarPath;
    }
}
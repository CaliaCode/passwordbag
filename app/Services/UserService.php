<?php

namespace App\Services;

// Framework
use Illuminate\Support\Facades\Storage;

// Repositories
use App\Repositories\RoleRepository;
use App\Repositories\UserInfoRepository;
use App\Repositories\UserRepository;

class UserService{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var UserInfoRepository
     */
    private $userInfoRepository;

    /**
     * UserService constructor.
     * 
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @param UserInfoRepository $userInfoRepository
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository,UserInfoRepository $userInfoRepository){

        $this->userRepository       = $userRepository;
        $this->roleRepository       = $roleRepository;
        $this->userInfoRepository   = $userInfoRepository;

    }

    /**
     * Create User
     * 
     * @param array $data
     * @return bool
     */
    public function createUser(array $data){

        $user = $this->userRepository->create($data['user']);

        $role = $this->roleRepository->getWhere('name', $data['role']['name']);

        $user->assignRole($role->id);
        
        if($data['role']['name']  == 'employer'){
            $user->assignedProjects()->attach($data['projects']);
        }

        $user->userInfo()->create($data['userInfo']);

        return true;

    }

    /**
     * Update User
     * 
     * @param $id
     * @param array $data
     * @return bool
     */
    public function updateUser($id, array $data){

        $user = $this->userRepository->update($id, $data['user']);

        $role = $this->roleRepository->getWhere('name', $data['role']['name']);

        $user->roles()->sync([$role->id]);

        $userInfo = $user->userInfo;

        if($data['role']['name']  == 'employer'){
            $user->assignedProjects()->sync($data['projects']);
        }else{
            $user->assignedProjects()->detach();
        }

        $avatarPath = $this->userInfoRepository->update($userInfo->id, $data['userInfo']);

        if($avatarPath){
            Storage::disk('public')->delete($avatarPath);
        }

        return true;
    }

    public function deleteUser($id){

        if($avatarPath = $this->userRepository->delete($id)){
            Storage::disk('public')->delete($avatarPath);
        }

        return true;

    }

    public function updateProfile($id, array $data){

        $user = $this->userRepository->update($id, $data['user']);

        $userInfo = $user->userInfo;

        $avatarPath = $this->userInfoRepository->update($userInfo->id, $data['userInfo']);

        if($avatarPath){
            Storage::disk('public')->delete($avatarPath);
        }

        return true;
    }

}
<?php

namespace App\Repositories;

// Models
use App\Models\UserInfo;

class UserInfoRepository{

    /**
     * @var UserInfo
     */
    private $userInfo;

    /**
     * UserInfoRepository constructor.
     *
     * @param UserInfo $userInfo
     */
    public function __construct(UserInfo $userInfo) {
        $this->userInfo = $userInfo;
    }

    /**
     * Retrieve UserInfo
     *
     * @param int $id
     * @return UserInfo
     */
    public function get($id)
    {
        return $this->userInfo->findOrFail($id);
    }

    /**
     * Create UserInfo
     *
     * @param array $data
     * @return UserInfo
     */
    public function create(array $data)
    {
        return $this->userInfo->create($data);
    }

    /**
     * Update UserInfo
     *
     * @param array $data
     * @return UserInfo
     */
    public function update($id, array $data)
    {
        $userInfo = $this->get($id);

        $userInfo->first_name = $data['first_name'];
        $userInfo->last_name = $data['last_name'];

        $avatarPath = false;

        if(array_key_exists('avatar', $data)){

            $avatarPath = $userInfo->avatar;

            if($avatarPath == 'uploads/avatars/avatar.png'){
                $avatarPath = false;
            }

            $userInfo->avatar = $data['avatar'];

        }

        $userInfo->save();

        return $avatarPath;
    }

}
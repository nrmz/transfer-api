<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Auth;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser($userData)
    {
        return $this->userRepository->create($userData);
    }

    public function getListOfUserWithMaxTransaction()
    {
        return $this->userRepository->listUserWithMaxTransaction();

    }

    public function login($userLoginData)
    {
        $user = null;
        if(Auth::attempt(['mobile' => $userLoginData['mobile'], 'password' => $userLoginData['password']])){
            $user = Auth::user();

        }
        return $user;
    }

}

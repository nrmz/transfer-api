<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {

        return response()->success(
            __('messages.received_successfully'),
            Response::HTTP_OK,
            $this->userService->getListOfUserWithMaxTransaction()
        );
    }
}

<?php

namespace Alimianesa\SmartAuth\Http\Controllers;

use Alive2212\LaravelSmartRestful\SmartCrudController;
use App\User;

class UserController extends SmartCrudController
{
    /**
     * @return void
     */
    public function initController()
    {
        $this->model = new User();
    }
}

<?php

namespace App\Controllers;


class AuthController extends BaseController {

    public function logout() { //evtl eigener Controller weil von überall aus Zugriff, jetzt erstmal nur Test
        auth()->logout();
        return redirect()->to('/login');
    }


}
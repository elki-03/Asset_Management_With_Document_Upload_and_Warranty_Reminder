<?php

namespace App\Controllers;

class DashboardController extends BaseController {
    
        public function showDashboard() {
        // helper('form'); // if later with form elements
        return view('/dashboard');
    }

    
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Dashboard Admin',
            'list' => ['Welcome','Dashboard Admin']
        ];

        $page = (object)[
            'title' => 'Dashboard Admin '
        ];

        $activeMenu = 'dashboard';

        return view('admin.dashboard', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
}

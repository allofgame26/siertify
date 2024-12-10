<?php

namespace App\Http\Controllers;

use App\Models\akunusermodel;
use App\Models\identitasmodel;
use App\Models\jenispenggunamodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $jenispengguna = jenispenggunamodel::count();

        $dosen = identitasmodel::count();

        $akun = akunusermodel::count();

        return view('dashboard.dashboard', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'jenispengguna' => $jenispengguna, 'dosen' => $dosen, 'akun' => $akun]);
    }
}

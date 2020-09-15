<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'page' => 'Dasbor',
            'user' => User::all(),
            'table' => Table::all(),
        ];
        return view('panel.dashboard', $data);
    }
}

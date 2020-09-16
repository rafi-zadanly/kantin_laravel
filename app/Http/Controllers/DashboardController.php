<?php

namespace App\Http\Controllers;

use App\Models\CanteenMenu;
use App\Models\Order;
use App\Models\Table;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'page' => 'Dasbor',
            'users' => User::all(),
            'menus' => CanteenMenu::all(),
            'tables' => Table::all(),
            'orders' => Order::all(),
            'transactions' => Transaction::all(),
        ];
        return view('panel.dashboard', $data);
    }
}

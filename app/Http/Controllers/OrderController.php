<?php

namespace App\Http\Controllers;

use App\Models\CanteenMenu;
use App\Models\Order;
use App\Models\Table;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\notInNull;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::orderBy('status', 'asc')->get();
        $user = $this->get_user($order);
        $menu = $this->get_menu($order);
        $transaction = $this->get_transaction($order);
        $table = $this->get_table($transaction);

        $data = [
            'page' => 'Pesanan',
            'orders' => $order,
            'user' => $user,
            'menu' => $menu,
            'table' => $table,
            'transaction' => $transaction,
        ];
        return view('panel.order.index', $data);
    }

    public function create()
    {
        $menu = CanteenMenu::where('status', 'available')->orderBy('name', 'asc')->get();
        $table = Table::all();
        $data = [
            'page' => 'Pesanan',
            'menus' => $menu,
            'tables' => $table,
        ];
        return view('panel.order.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meja' => ['required', new notInNull],
            'menu' => ['required', new notInNull],
            'kuantitas' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'msg' => 'Isikan form dengan benar']);
        }else{
            $check = Transaction::where('table_id', $request->meja)->where('status', 'unpaid')->first();
            $transaction_id = $check ? $check->id : '';
            if ($transaction_id == '') {
                $transaction = new Transaction();
                $transaction->table_id = $request->meja;
                $transaction->date = date('Y-m-d', strtotime(now()));
                $transaction->status = "unpaid";
                $transaction->save();
                $transaction_id = Transaction::orderBy('id', 'desc')->first()->id;
            }

            $order = new Order();
            $order->transaction_id = $transaction_id;
            $order->user_id = Session::get('user_id');
            $order->canteen_menu_id = $request->menu;
            $order->quantity = $request->kuantitas;
            $order->total = CanteenMenu::find($request->menu)->price * $request->kuantitas;
            $order->notes = $request->catatan == NULL ? "-" : $request->catatan ;
            $order->status = "proses";

            if($order->save()){
                return response()->json(['status' => 'success', 'msg' => 'Berhasil menambahkan pesanan.', 'meja' => $request->meja]);
            }else{
                return response()->json(['status' => 'failed', 'msg' => 'Gagal menambahkan pesanan.', 'meja' => $request->meja]);
            }
        }
        
    }

    public function show(Order $order)
    {
        //
    }

    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }

    public function store_session()
    {

    }

    public function get_user($array)
    {
        $data = [];
        foreach ($array as $d) {
            $data[] = User::find($d->user_id);
        }
        return $data;
    }

    public function get_menu($array)
    {
        $data = [];
        foreach ($array as $d) {
            $data[] = CanteenMenu::find($d->canteen_menu_id);
        }
        return $data;
    }

    public function get_transaction($array)
    {
        $data = [];
        foreach ($array as $d) {
            $data[] = Transaction::find($d->transaction_id);
        }
        return $data;
    }

    public function get_table($array)
    {
        $data = [];
        foreach ($array as $d) {
            $data[] = Table::find($d->table_id);
        }
        return $data;
    }

    public function get_table_ordered(Request $request)
    {
        $data = DB::table('transactions')
            ->where('transactions.table_id', $request->meja)
            ->where('transactions.status', 'unpaid')
            ->orderBy('orders.status', 'asc')
            ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
            ->join('canteen_menus', 'orders.canteen_menu_id', '=', 'canteen_menus.id')
            ->select('orders.*', 'canteen_menus.name')
            ->get();

        return response()->json($data);
    }

    public function order_done(Request $request){
        $update = ['status' => 'selesai'];
        if (Order::find($request->id)->update($update)) {
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'failed']);
        }
    }
}

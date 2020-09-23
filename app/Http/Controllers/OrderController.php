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
        $order = DB::table('orders')
            ->join('canteen_menus', 'canteen_menus.id', '=', 'orders.canteen_menu_id')
            ->join('transactions', 'transactions.id', '=', 'orders.transaction_id')
            ->join('tables', 'tables.id', '=', 'transactions.table_id')
            ->orderBy('orders.status', 'asc')
            ->select(
                'orders.id',
                'orders.quantity', 
                'orders.total', 
                'orders.notes',
                'orders.status',
                'canteen_menus.name', 
                'canteen_menus.price',  
                'tables.number'
            )->get();

        $data = [
            'page' => 'Pesanan',
            'orders' => $order,
        ];

        return view('panel.order.index', $data);
    }

    public function create_data(){
        $menu = CanteenMenu::where('status', 'available')->orderBy('name', 'asc')->get();
        $table = Table::orderBy('number', 'asc')->get();
        $data = [
            'menus' => $menu,
            'tables' => $table,
        ];
        return response()->json($data);
    }

    public function create()
    {
        $data = [
            'page' => 'Pesanan',
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
                return response()->json(['status' => 'success', 'msg' => 'Berhasil menambahkan pesanan.']);
            }else{
                return response()->json(['status' => 'failed', 'msg' => 'Gagal menambahkan pesanan.']);
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

    public function get_table_ordered(Request $request)
    {
        $data = DB::table('transactions')
            ->where('transactions.table_id', $request->meja)
            ->where('transactions.status', 'unpaid')
            ->orderBy('orders.status', 'asc')
            ->orderBy('created_at', 'desc')
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

    public function order_cancel(Request $request){
        if (Order::find($request->id)->delete()) {
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'failed']);
        }
    }
}

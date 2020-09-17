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
use PDF;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::orderBy('created_at', 'desc')->get();
        $table = $this->get_table($transaction);
        $data = [
            'page' => 'Transaksi',
            'transactions' => $transaction,
            'tables' => $table,
        ];
        return view('panel.transaction.index', $data);
    }

    public function create()
    {
        $table = Table::all();
        $data = [
            'page' => 'Transaksi',
            'tables' => $table,
        ];
        return view('panel.transaction.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meja' => ['required', new notInNull],
            'total' => 'required',
            'uang' => 'required',
            'kembali' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed', 'msg' => 'Isikan form dengan benar']);
        }else{
            $update = [
                'cash' => $request->uang,
                'change' => $request->kembali,
                'status' => 'paid',
                'user_id' => Session::get('user_id'),
            ];
            $transaction_id = Transaction::where('table_id', $request->meja)->where('status', 'unpaid')->first()->id;
            $updating = Order::where('transaction_id', $transaction_id)->update(['status' => 'selesai']);
            $updating = Transaction::where('table_id', $request->meja)
                ->where('status', 'unpaid')->update($update);
            if ($updating) {
                return response()->json(['status' => 'success', 'msg' => 'Berhasil melakukan transaksi.', 'id' => $transaction_id]);
            }else{
                return response()->json(['status' => 'failed', 'msg' => 'Terjadi kesalahan pada sistem, coba lagi nanti.', 'id' => $transaction_id]);
            }
        }
    }

    public function show(Transaction $transaction)
    {
        //
    }

    public function edit(Transaction $transaction)
    {
        //
    }

    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    public function destroy(Transaction $transaction)
    {
        //
    }

    public function get_table($array)
    {
        $data = [];
        foreach ($array as $d) {
            $data[] = Table::find($d->table_id);
        }
        return $data;
    }

    public function get_table_transaction(Request $request)
    {
        $total = 0;
        foreach ($this->all_relation_data($request) as $d) {
            $total += $d->price * $d->quantity;
        }
        $update = ['total' => $total];
        $updating = Transaction::where('table_id', $request->meja)
            ->where('status', 'unpaid')->update($update);
        if ($updating && $this->all_relation_data($request) != NULL) {
            return response()->json($this->all_relation_data($request));
        }else{
            return response()->json([]);
        }
    }

    public function all_relation_data($request)
    {
        return DB::table('transactions')
            ->where('transactions.table_id', $request->meja)
            ->where('transactions.status', 'unpaid')
            ->join('orders', 'transactions.id', '=', 'orders.transaction_id')
            ->join('canteen_menus', 'orders.canteen_menu_id', '=', 'canteen_menus.id')
            ->select('orders.*', 'canteen_menus.*', 'transactions.*')
            ->get();
    }

    public function get_invoice(Request $request)
    {
        if ($request->id == NULL){
            return redirect()->back();
        }
        try {
            $user_id = Transaction::find($request->id)->user_id;
            $transaction = Transaction::find($request->id);
            $order = Order::where('transaction_id', $transaction->id)->get();
            $menu = [];
            foreach ($order as $o) {
                $menu[] = CanteenMenu::find($o->canteen_menu_id);
            }
            $data = [
                'orders' => $order,
                'menu' => $menu,
                'date' => $transaction->updated_at,
                'total' => $transaction->total,
                'cash' => $transaction->cash,
                'change' => $transaction->change,
                'user' => User::find($user_id)->name,
            ];
            $pdf = PDF::loadView('pdf.invoice', $data);
            return $pdf->stream();
            // return $pdf->download("invoice_$request->id.pdf");
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $message = [
        'required' => ':attribute harus diisi.',
        'min' => ':attribute minimal :min karakter.',
        'max' => ':attribute maksimal :max karakter.',
        'numeric' => ':attribute harus berupa angka.',
        'unique' => ':attribute sudah digunakan.',
    ];

    public function success_redirect(string $msg, string $route)
    {
        return redirect()->route($route)
                ->with('alert', $msg)
                ->with('type', 'success');
    }

    public function error_redirect()
    {
        return redirect()->back()
            ->with('alert', 'Terjadi kesalahan pada sistem, coba lagi nanti.')
            ->with('type', 'danger');
    }

    public function validate_fails($validator)
    {
        return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('alert', 'Pengisian form tidak valid, mohon di isi dengan benar.')
                ->with('type', 'danger');
    }
}

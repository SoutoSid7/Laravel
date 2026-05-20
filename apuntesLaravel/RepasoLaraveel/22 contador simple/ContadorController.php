<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContadorController extends Controller
{
    public function index()
    {
        if (!session()->has('contador')) {
            session(['contador' => 0]);
        }

        return view('contador', [
            'contador' => session('contador'),
        ]);
    }

    public function sumar()
    {
        session(['contador' => session('contador') + 1]);
        return redirect()->route('contador.index');
    }

    public function restar()
    {
        session(['contador' => session('contador') - 1]);
        return redirect()->route('contador.index');
    }

    public function reiniciar()
    {
        session(['contador' => 0]);
        return redirect()->route('contador.index');
    }
}
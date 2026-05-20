<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TirarDadoController extends Controller
{
    public function index()
    {
        if (!session()->has('historial')) {
            session(['historial' => []]);
        }

        return view('tirar_dado', [
            'dado'      => session('dado'),
            'historial' => session('historial'),
        ]);
    }

    public function tirar()
    {
        $dado = rand(1, 6);
        $historial = session('historial', []);
        $historial[] = $dado;

        session(['dado' => $dado, 'historial' => $historial]);
        return redirect()->route('tirardado.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('tirardado.index');
    }
}
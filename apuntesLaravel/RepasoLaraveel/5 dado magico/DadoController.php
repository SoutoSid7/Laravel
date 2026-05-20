<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DadoController extends Controller
{
    public function index()
    {
        if (!session()->has('racha')) {
            session(['racha' => 0, 'tiradas' => 0, 'ganado' => false]);
        }

        return view('dado', [
            'racha'   => session('racha'),
            'tiradas' => session('tiradas'),
            'ganado'  => session('ganado'),
            'dado'    => session('dado'),
            'mensaje' => session('mensaje', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['apuesta' => 'required|integer|min:1|max:6']);

        if (session('ganado')) {
            return redirect()->route('dado.index');
        }

        $apuesta = (int) $request->input('apuesta');
        $dado    = rand(1, 6);

        if ($apuesta === $dado) {
            $racha = session('racha') + 1;
            $mensaje = "¡Acertaste! Salió {$dado}. Racha: {$racha}/3";
            if ($racha >= 3) {
                session(['ganado' => true]);
                $mensaje = "🏆 ¡GANASTE! 3 aciertos seguidos.";
            }
            session(['racha' => $racha]);
        } else {
            $mensaje = "Fallaste. Apostaste {$apuesta}, salió {$dado}. Racha reiniciada.";
            session(['racha' => 0]);
        }

        session([
            'dado'    => $dado,
            'tiradas' => session('tiradas') + 1,
            'mensaje' => $mensaje,
        ]);

        return redirect()->route('dado.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('dado.index');
    }
}
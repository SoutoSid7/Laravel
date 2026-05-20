<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesoroController extends Controller
{
    public function index()
    {
        if (!session()->has('tesoro')) {
            session([
                'tesoro'    => rand(1, 9),
                'intentos'  => 0,
                'max'       => 4,
                'probadas'  => [],
                'ganado'    => false,
                'perdido'   => false,
            ]);
        }

        return view('tesoro', [
            'intentos' => session('intentos'),
            'max'      => session('max'),
            'probadas' => session('probadas'),
            'ganado'   => session('ganado'),
            'perdido'  => session('perdido'),
            'tesoro'   => session('tesoro'),
            'mensaje'  => session('mensaje', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['casilla' => 'required|integer|min:1|max:9']);

        if (session('ganado') || session('perdido')) {
            return redirect()->route('tesoro.index');
        }

        $casilla  = (int) $request->input('casilla');
        $probadas = session('probadas', []);

        if (in_array($casilla, $probadas)) {
            session(['mensaje' => "Ya probaste la casilla {$casilla}."]);
            return redirect()->route('tesoro.index');
        }

        $probadas[] = $casilla;
        $intentos   = session('intentos') + 1;

        if ($casilla === session('tesoro')) {
            session(['ganado' => true, 'mensaje' => "🏆 ¡Encontraste el tesoro en la casilla {$casilla}!"]);
        } elseif ($intentos >= session('max')) {
            session(['perdido' => true, 'mensaje' => "💀 Sin intentos. El tesoro estaba en " . session('tesoro')]);
        } else {
            session(['mensaje' => "Vacío. Te quedan " . (session('max') - $intentos) . " intentos."]);
        }

        session(['intentos' => $intentos, 'probadas' => $probadas]);
        return redirect()->route('tesoro.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('tesoro.index');
    }
}
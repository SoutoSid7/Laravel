<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BombaController extends Controller
{
    public function index()
    {
        if (!session()->has('limite')) {
            session([
                'limite'  => rand(3, 10),
                'cortes'  => 0,
                'estado'  => 'jugando', // jugando | desactivada | explotada
            ]);
        }

        return view('bomba', [
            'cortes'  => session('cortes'),
            'estado'  => session('estado'),
            'limite'  => session('limite'),
            'mensaje' => session('mensaje', ''),
        ]);
    }

    public function cortar()
    {
        if (session('estado') !== 'jugando') {
            return redirect()->route('bomba.index');
        }

        $cortes = session('cortes') + 1;
        session(['cortes' => $cortes]);

        if ($cortes >= session('limite')) {
            session(['estado' => 'explotada', 'mensaje' => "💥 ¡BOOM! Explotó al corte {$cortes}."]);
        } else {
            session(['mensaje' => "Cortaste un cable. Llevas {$cortes}."]);
        }

        return redirect()->route('bomba.index');
    }

    public function desactivar()
    {
        if (session('estado') !== 'jugando') {
            return redirect()->route('bomba.index');
        }

        session([
            'estado'  => 'desactivada',
            'mensaje' => "🏆 ¡Bomba desactivada! Cortaste " . session('cortes') . " cables (el límite era " . session('limite') . ").",
        ]);

        return redirect()->route('bomba.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('bomba.index');
    }
}
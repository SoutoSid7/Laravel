<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EscaleraController extends Controller
{
    const META = 20;

    public function index()
    {
        if (!session()->has('escalon')) {
            session([
                'escalon'  => 0,
                'caidas'   => 0,
                'subidas'  => 0,
                'ganado'   => false,
            ]);
        }

        return view('escalera', [
            'escalon' => session('escalon'),
            'caidas'  => session('caidas'),
            'subidas' => session('subidas'),
            'ganado'  => session('ganado'),
            'meta'    => self::META,
            'mensaje' => session('mensaje', ''),
        ]);
    }

    public function subir()
    {
        if (session('ganado')) {
            return redirect()->route('escalera.index');
        }

        $tirada = rand(0, 3);
        session(['subidas' => session('subidas') + 1]);

        if ($tirada === 0) {
            session([
                'escalon' => 0,
                'caidas'  => session('caidas') + 1,
                'mensaje' => "💥 ¡Te caíste! Vuelves al inicio.",
            ]);
        } else {
            $nuevo = session('escalon') + $tirada;
            session(['escalon' => $nuevo, 'mensaje' => "Subiste {$tirada} escalones."]);

            if ($nuevo >= self::META) {
                session(['ganado' => true, 'mensaje' => "🏆 ¡Llegaste a la cima!"]);
            }
        }

        return redirect()->route('escalera.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('escalera.index');
    }
}
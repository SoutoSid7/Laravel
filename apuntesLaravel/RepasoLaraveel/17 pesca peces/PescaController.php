<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PescaController extends Controller
{
    public function index()
    {
        if (!session()->has('puntos')) {
            session([
                'puntos'      => 0,
                'lanzamientos'=> 0,
                'max'         => 10,
                'pesca'       => [],
            ]);
        }

        return view('pesca', [
            'puntos'       => session('puntos'),
            'lanzamientos' => session('lanzamientos'),
            'max'          => session('max'),
            'pesca'        => session('pesca'),
            'mensaje'      => session('mensaje', ''),
        ]);
    }

    public function lanzar()
    {
        if (session('lanzamientos') >= session('max')) {
            return redirect()->route('pesca.index');
        }

        $tipos = [
            ['nombre' => '🐠 Pez pequeño',  'puntos' => 5],
            ['nombre' => '🐟 Pez mediano',  'puntos' => 10],
            ['nombre' => '🐡 Pez grande',   'puntos' => 20],
            ['nombre' => '🦈 Tiburón',      'puntos' => 50],
            ['nombre' => '🥾 Bota vieja',   'puntos' => -10],
            ['nombre' => '🗑️ Basura',       'puntos' => -5],
        ];

        $captura = $tipos[array_rand($tipos)];
        $pesca   = session('pesca');
        $pesca[] = $captura['nombre'] . ' (' . $captura['puntos'] . ')';

        session([
            'puntos'       => session('puntos') + $captura['puntos'],
            'lanzamientos' => session('lanzamientos') + 1,
            'pesca'        => $pesca,
            'mensaje'      => "Pescaste: {$captura['nombre']} ({$captura['puntos']} puntos)",
        ]);

        if (session('lanzamientos') >= session('max')) {
            $p = session('puntos');
            $msg = "🎣 Fin de la pesca. Total: {$p} puntos. ";
            $msg .= $p >= 100 ? '🏆 ¡Pescador experto!' : ($p >= 50 ? '👍 Buena pesca' : '👎 Mala suerte');
            session(['mensaje' => $msg]);
        }

        return redirect()->route('pesca.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('pesca.index');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalletasController extends Controller
{
    const META = 50;

    public function index()
    {
        if (!session()->has('galletas')) {
            session(['galletas' => 0, 'clicks' => 0, 'mejor' => session('mejor')]);
        }

        return view('galletas', [
            'galletas' => session('galletas'),
            'clicks'   => session('clicks'),
            'mejor'    => session('mejor'),
            'meta'     => self::META,
            'mensaje'  => session('mensaje', ''),
        ]);
    }

    public function meter()
    {
        if (session('galletas') >= self::META) {
            return redirect()->route('galletas.index');
        }

        $cantidad = rand(1, 3);
        $nuevas   = session('galletas') + $cantidad;
        $clicks   = session('clicks') + 1;
        $mensaje  = "Metiste {$cantidad} galletas.";

        if ($nuevas >= self::META) {
            $mensaje = "🏆 ¡Llenaste el bote en {$clicks} clicks!";
            $mejor   = session('mejor');
            if (!$mejor || $clicks < $mejor) {
                session(['mejor' => $clicks]);
                $mensaje .= " ¡NUEVO RÉCORD!";
            }
        }

        session([
            'galletas' => $nuevas,
            'clicks'   => $clicks,
            'mensaje'  => $mensaje,
        ]);

        return redirect()->route('galletas.index');
    }

    public function reiniciar()
    {
        $mejor = session('mejor');
        session()->flush();
        session(['mejor' => $mejor]); // conservamos el récord
        return redirect()->route('galletas.index');
    }
}
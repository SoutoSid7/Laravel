<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CajasController extends Controller
{
    public function index()
    {
        if (!session()->has('premios')) {
            session([
                'premios' => 0,
                'rondas'  => 0,
                'max'     => 5,
                'ganado'  => false,
            ]);
        }

        return view('cajas', [
            'premios' => session('premios'),
            'rondas'  => session('rondas'),
            'max'     => session('max'),
            'ganado'  => session('ganado'),
            'eleccion'=> session('eleccion'),
            'mensaje' => session('mensaje', ''),
        ]);
    }

    public function abrir(Request $request)
    {
        $request->validate(['caja' => 'required|integer|min:1|max:3']);

        if (session('ganado') || session('rondas') >= session('max')) {
            return redirect()->route('cajas.index');
        }

        $caja      = (int) $request->input('caja');
        $contenido = ['premio', 'carbon', 'nada'];
        shuffle($contenido);
        $resultado = $contenido[$caja - 1];

        $mensajes = [
            'premio' => "🎁 ¡PREMIO! Encontraste un regalo.",
            'carbon' => "🪨 Carbón. Mala suerte.",
            'nada'   => "📦 Caja vacía.",
        ];

        $mensaje = $mensajes[$resultado];

        if ($resultado === 'premio') {
            session(['premios' => session('premios') + 1]);
        }

        session([
            'rondas'   => session('rondas') + 1,
            'eleccion' => $caja,
            'mensaje'  => $mensaje,
        ]);

        if (session('premios') >= 3) {
            session(['ganado' => true, 'mensaje' => "🏆 ¡GANASTE! 3 premios encontrados."]);
        } elseif (session('rondas') >= session('max')) {
            session(['mensaje' => "Fin del juego. Conseguiste " . session('premios') . " premios."]);
        }

        return redirect()->route('cajas.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('cajas.index');
    }
}
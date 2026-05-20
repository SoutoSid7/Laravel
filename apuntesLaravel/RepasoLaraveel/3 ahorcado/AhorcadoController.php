<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AhorcadoController extends Controller
{
    private $palabras = ['laravel', 'programacion', 'controlador', 'modelo', 'vista', 'php', 'sesion', 'ruta'];

    public function index()
    {
        if (!session()->has('palabra')) {
            $palabra = $this->palabras[array_rand($this->palabras)];
            session([
                'palabra'  => $palabra,
                'aciertos' => [],
                'fallos'   => [],
                'max_fallos' => 6,
            ]);
        }

        $palabra = session('palabra');
        $aciertos = session('aciertos');
        $mostrada = '';
        foreach (str_split($palabra) as $letra) {
            $mostrada .= in_array($letra, $aciertos) ? $letra : '_';
            $mostrada .= ' ';
        }

        $ganado  = !str_contains($mostrada, '_');
        $perdido = count(session('fallos')) >= session('max_fallos');

        return view('ahorcado', [
            'mostrada'   => $mostrada,
            'fallos'     => session('fallos'),
            'max_fallos' => session('max_fallos'),
            'ganado'     => $ganado,
            'perdido'    => $perdido,
            'palabra'    => $palabra,
            'mensaje'    => session('mensaje', ''),
        ]);
    }

    public function jugar(Request $request)
    {
        $request->validate(['letra' => 'required|string|size:1']);

        $letra    = strtolower($request->input('letra'));
        $palabra  = session('palabra');
        $aciertos = session('aciertos', []);
        $fallos   = session('fallos', []);

        if (in_array($letra, $aciertos) || in_array($letra, $fallos)) {
            session(['mensaje' => "Ya probaste la letra '{$letra}'."]);
            return redirect()->route('ahorcado.index');
        }

        if (str_contains($palabra, $letra)) {
            $aciertos[] = $letra;
            session(['mensaje' => "¡Bien! '{$letra}' está en la palabra."]);
        } else {
            $fallos[] = $letra;
            session(['mensaje' => "Fallaste. '{$letra}' no está."]);
        }

        session(['aciertos' => $aciertos, 'fallos' => $fallos]);
        return redirect()->route('ahorcado.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('ahorcado.index');
    }
}
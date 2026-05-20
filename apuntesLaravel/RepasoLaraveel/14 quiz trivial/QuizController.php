<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    private $preguntas = [
        ['pregunta' => '¿Capital de Francia?',          'opciones' => ['Madrid', 'París', 'Roma'],     'correcta' => 1],
        ['pregunta' => '¿Cuánto es 7 x 8?',             'opciones' => ['54', '56', '64'],              'correcta' => 1],
        ['pregunta' => '¿Año del descubrimiento de América?', 'opciones' => ['1492', '1500', '1453'],  'correcta' => 0],
        ['pregunta' => '¿Planeta más grande?',          'opciones' => ['Saturno', 'Júpiter', 'Tierra'],'correcta' => 1],
        ['pregunta' => '¿Lenguaje de Laravel?',         'opciones' => ['Python', 'PHP', 'JavaScript'], 'correcta' => 1],
    ];

    public function index()
    {
        if (!session()->has('actual')) {
            session(['actual' => 0, 'aciertos' => 0]);
        }

        $actual = session('actual');
        $fin    = $actual >= count($this->preguntas);

        return view('quiz', [
            'actual'   => $actual,
            'total'    => count($this->preguntas),
            'aciertos' => session('aciertos'),
            'pregunta' => $fin ? null : $this->preguntas[$actual],
            'fin'      => $fin,
            'mensaje'  => session('mensaje', ''),
        ]);
    }

    public function responder(Request $request)
    {
        $request->validate(['opcion' => 'required|integer|min:0|max:2']);

        $actual = session('actual');
        if ($actual >= count($this->preguntas)) {
            return redirect()->route('quiz.index');
        }

        $opcion    = (int) $request->input('opcion');
        $correcta  = $this->preguntas[$actual]['correcta'];

        if ($opcion === $correcta) {
            session(['aciertos' => session('aciertos') + 1, 'mensaje' => '✅ ¡Correcto!']);
        } else {
            $texto = $this->preguntas[$actual]['opciones'][$correcta];
            session(['mensaje' => "❌ Incorrecto. Era: {$texto}"]);
        }

        session(['actual' => $actual + 1]);
        return redirect()->route('quiz.index');
    }

    public function reiniciar()
    {
        session()->flush();
        return redirect()->route('quiz.index');
    }
}
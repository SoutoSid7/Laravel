<?php
// Importa la clase Route, que es la fachada de Laravel para definir rutas.
use Illuminate\Support\Facades\Route;
// Importa tu controlador para poder usarlo en las rutas más abajo.
use App\Http\Controllers\JuegoController;

// RUTA GET: Es la ruta de "lectura" a la que entras cuando escribes la URL normal.
// Cuando alguien entra a la raíz de la web ('/'), ejecuta la función 'index' del JuegoController.
// ->name('juego.index') le da un "apodo" a la ruta para poder llamarla desde la vista sin escribir la URL a mano.
Route::get('/', [JuegoController::class, 'index'])->name('juego.index');

// RUTA POST: Solo se puede acceder a ella enviando un formulario. Procesa datos.
// Cuando el formulario de los botones 'Mayor/Menor' se envía a '/cartas', ejecuta 'jugar'.
Route::post('/cartas', [JuegoController::class, 'jugar'])->name('juego.jugar');

// RUTA POST: Para reiniciar el juego.
// Cuando el botón de 'Reiniciar' envía sus datos a '/reiniciar', ejecuta 'reiniciar'.
Route::post('/reiniciar', [JuegoController::class, 'reiniciar'])->name('juego.reiniciar');
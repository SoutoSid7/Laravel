// 1. Comprobar si existe algo en sesión (ideal para inicializar)
if (!session()->has('puntos')) { ... }

// 2. Guardar uno o varios valores
session(['puntos' => 0, 'estado' => 'jugando']);

// 3. Leer un valor (con valor por defecto si no existe)
$puntos = session('puntos', 0); // Si no existe, devuelve 0

// 4. AÑADIR a un array que está en sesión (¡Súper importante!)
$historial = session('historial', []); // 1. Lo sacamos (o creamos vacío)
$historial[] = 'Nueva jugada';         // 2. Lo modificamos
session(['historial' => $historial]);  // 3. Lo volvemos a guardar

// 5. Borrar una variable específica de la sesión
session()->forget('racha');

// 6. Destruir TODA la sesión (Resetear el juego)
session()->flush();

// 7. Leer y borrar en un solo paso (útil para mensajes flash manuales)
$mensaje = session()->pull('mensaje_secreto');
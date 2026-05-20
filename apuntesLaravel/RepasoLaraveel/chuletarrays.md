$mazo = ['As', 'Rey', 'Reina', 'Jota', '10'];

// 1. array_shift(): Saca el PRIMER elemento y lo borra del array.
// Útil para sacar cartas de arriba del mazo.
$carta_sacada = array_shift($mazo); 
// $carta_sacada = 'As'. $mazo ahora es ['Rey', 'Reina', 'Jota', '10']

// 2. array_pop(): Saca el ÚLTIMO elemento y lo borra.
$ultima = array_pop($mazo);

// 3. array_splice(): Cortar un trozo del array (quita elementos en medio).
// array_splice($array, $posicion_inicio, $cantidad_a_quitar)
$array = ['A', 'B', 'C', 'D', 'E'];
array_splice($array, 2, 1); // Quita 1 elemento desde la posición 2 (la 'C')
// El array queda: ['A', 'B', 'D', 'E'] (¡reordena los índices automáticamente!)

// 4. unset(): Borra un elemento por su índice, PERO NO reordena los índices numéricos.
// (Mejor usar array_splice si es un array numérico continuo).
unset($array[1]); 

// 5. array_slice(): Copia un trozo del array SIN borrarlo del original.
// Útil para hacer "Top 3" o "Últimos 5 movimientos".
$top_3 = array_slice($ranking, 0, 3); // Coge los 3 primeros.
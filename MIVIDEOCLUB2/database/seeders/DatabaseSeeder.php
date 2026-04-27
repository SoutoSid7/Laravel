<?php

namespace Database\Seeders;

use App\Models\User; // Importar Movie
use Illuminate\Support\Facades\DB; // Importar DataBase
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Array de usuarios a insertar
     */

	private $arrayUsuarios = array(
		array(
			'name' => 'nomavi',
			'email' => 'miguel@gmail.com',
			'password' => '123_4'
		),
		array(
			'name' => 'yolanda',
			'email' => 'yolanda@gmail.com',
			'password' => '123_4'
		),
		array(
			'name' => 'joel',
			'email' => 'joel@gmail.com',
			'password' => '123_4'
		),
		array(
			'name' => 'mario',
			'email' => 'mario@gmail.com',
			'password' => '123_4'
		),
		array(
			'name' => 'moreno',
			'email' => 'moreno@gmail.com',
			'password' => '123_4'
		),
	);

	/**
	 * Seed the aplication's database
	 */

	public function run()
	{
		$this->seedUsers();
		$this->command->info('Tabla usuarios inicializada con datos!');
	}

	private function seedUsers() 
	{
		// Vaciamos la tabla por si ya tenia datos anteriormente
		// Desactivamos la revision de clave foraneas por si hay relaciones
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('users')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');

		// Itereamos sobre el array para crear los registros
		foreach( $this->arrayUsuarios as $usuario ){
			$u = new User; // Modelo en singular y con mayuscula
			$u->name = $usuario['name'];
			$u->email = $usuario['email'];
			// Contraseña en Laravel DEBEN estar encriptadas
			$u->password = bcrypt($usuario['password']);

			/**
			 * Los campos 'id' (autoincremental) y 'timestamps' (created_at, updated_at)
			 * Los gestiona Eloquent automaticamente al hacer save()
			 * El 'remember_token' se queda nulo hasta que se use la fuincion de "recordar sesion"
			 */
			$u->save();
		}
	}
} 

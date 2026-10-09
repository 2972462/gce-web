<?php

namespace Database\Seeders;

use App\Models\Pagina;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->seedAdmin();
        $this->seedPaginaHome();
    }

    protected function seedAdmin(): void
    {
        if (User::where('email', 'rodriguezantoni@gmail.com')->exists()) {
            return;
        }

        $password = Str::password(16);

        User::create([
            'name' => 'Antonio Rodriguez',
            'email' => 'rodriguezantoni@gmail.com',
            'password' => $password,
        ]);

        $this->command?->warn("Usuario admin creado: rodriguezantoni@gmail.com / {$password} (cambiar tras el primer login)");
    }

    protected function seedPaginaHome(): void
    {
        $pagina = Pagina::firstOrCreate(
            ['slug' => 'home'],
            ['titulo' => 'Inicio']
        );

        $secciones = [
            ['clave' => 'hero', 'titulo' => 'Hero'],
            ['clave' => 'nosotros', 'titulo' => 'Nosotros'],
            ['clave' => 'servicios', 'titulo' => 'Servicios'],
            ['clave' => 'licitaciones', 'titulo' => 'Licitaciones'],
            ['clave' => 'ventajas', 'titulo' => 'Ventajas'],
            ['clave' => 'contacto', 'titulo' => 'Contacto'],
        ];

        foreach ($secciones as $orden => $datos) {
            $seccion = $pagina->secciones()->firstOrCreate(
                ['clave' => $datos['clave']],
                ['titulo' => $datos['titulo'], 'orden' => $orden]
            );

            if ($seccion->bloques()->exists()) {
                continue;
            }

            match ($datos['clave']) {
                'hero' => $seccion->bloques()->create([
                    'tipo' => 'texto',
                    'orden' => 0,
                    'contenido' => [
                        'titulo' => 'Bienvenido a GCE',
                        'cuerpo' => 'Texto de bienvenida de la página principal.',
                    ],
                ]),
                'contacto' => $seccion->bloques()->create([
                    'tipo' => 'boton',
                    'orden' => 0,
                    'contenido' => [
                        'texto' => 'Contactanos',
                        'url' => '#contacto',
                        'estilo' => 'primario',
                    ],
                ]),
                default => $seccion->bloques()->create([
                    'tipo' => 'texto',
                    'orden' => 0,
                    'contenido' => [
                        'titulo' => $datos['titulo'],
                        'cuerpo' => 'Contenido pendiente de completar.',
                    ],
                ]),
            };
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Creamos unas cuantas etiquetas reales en la tabla 'etiquetas'
        $etiquetas = ['Artesanal', 'Ecológico', 'Oferta', 'Hecho a Mano', 'Temporada', 'Premium', 'Local', 'Tradicional'];
        $etiquetasIds = [];
        
        foreach ($etiquetas as $nombreEtiqueta) {
            $etiquetasIds[] = DB::table('etiquetas')->insertGetId([
                'nombre' => $nombreEtiqueta,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Listas de datos realistas en español para combinar
        $sectores = ['Calzados', 'Frutería', 'Textil', 'Embutidos', 'Artesanías', 'Encurtidos', 'Flores', 'Moda Vintage'];
        $poblaciones = ['Valencia', 'Torrent', 'Mislata', 'Alzira', 'Gandia', 'Xàtiva', 'Sagunto', 'Paterna'];
        $mercadillos = ['Mercadillo Central', 'Mercadillo de los Martes', 'Feria Local', 'Mercadillo de Nazaret', 'Plaza Mayor'];

        $descripciones = [
            "Ofrecemos la mejor calidad directamente seleccionada para nuestros clientes, manteniendo la tradición familiar y un trato cercano.",
            "Especialistas con más de 15 años de experiencia trayendo productos exclusivos y artesanales al mejor precio del mercado ambulante.",
            "Tu puesto de confianza. Género fresco todas las semanas con ofertas especiales que no encontrarás en grandes superficies.",
            "Pasión por lo que hacemos. Ropa y complementos únicos con un stock renovado constantemente para adaptarnos a las últimas tendencias."
        ];

        // 2. Bucle principal para generar los 100 comerciantes con todo su ecosistema en cascada
        for ($i = 1; $i <= 100; $i++) {

            // A. Crear Usuario Comerciante (respetando tus campos de apellido desglosados)
            $userId = DB::table('users')->insertGetId([
                'nombre' => 'Comerciante ' . $i,
                'primer_apellido' => 'Apellido' . $i,
                'segundo_apellido' => 'Sánchez',
                'email' => "comerciante{$i}@mercazone.com",
                'password' => Hash::make('password'), // Contraseña idéntica para todos: password
                'rol' => 'Comerciante',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $sector = $sectores[array_rand($sectores)];

            // B. Crear el Negocio asociado (tabla 'negocio')
            $negocioId = DB::table('negocio')->insertGetId([
                'user_id' => $userId,
                'reservation_id' => null,
                'nombre_negocio' => "{$sector} " . fake()->firstName(),
                'descripcion' => $descripciones[array_rand($descripciones)] . " ¡Ven a visitarnos al puesto!",
                'numero_permiso' => rand(10000, 99999),
                'nif' => rand(10000000, 99999999) . chr(rand(65, 90)), // Genera NIF aleatorio (8 números y 1 letra)
                'telefono' => rand(600000000, 799999999),
                'imagen' => "https://picsum.photos/id/" . ($i + 10) . "/300/300", // URL estable para el Logotipo
                'estado_validacion' => 'validado',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // C. Crear el Carrusel de imágenes (tabla 'imagen_negocio') - 3 fotos por negocio
            for ($img = 1; $img <= 3; $img++) {
                DB::table('imagen_negocio')->insert([
                    'negocio_id' => $negocioId,
                    'ruta' => "https://picsum.photos/id/" . (($i * 3) + $img + 50) . "/800/400", // Imagen horizontal para el carrusel
                    'orden' => $img,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // D. Crear Horarios completando los 7 días de la semana con distintas ubicaciones (tabla 'horario_negocio')
            $diasSemana = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
            foreach ($diasSemana as $dia) {
                DB::table('horario_negocio')->insert([
                    'negocio_id' => $negocioId,
                    'dia' => $dia,
                    'apertura' => '08:00:00',
                    'cierre' => '14:30:00',
                    'festivo_cerrado' => false,
                    'poblacion' => $poblaciones[array_rand($poblaciones)],
                    'ubicacion' => $mercadillos[array_rand($mercadillos)] . " - Puesto #" . rand(1, 150),
                    'latitud' => 39.46975000 + (rand(-100, 100) / 1000), // Coordenadas aproximadas reales de la Comunidad Valenciana
                    'longitud' => -0.37739000 + (rand(-100, 100) / 1000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // E. Crear 4 Productos por cada uno de los negocios (tabla 'productos')
            for ($p = 1; $p <= 4; $p++) {
                $productoId = DB::table('productos')->insertGetId([
                    'negocio_id' => $negocioId,
                    'nombre' => "Producto {$p} de {$sector}",
                    'descripcion' => "Excelente artículo de la gama de {$sector}, totalmente garantizado y revisado por el comerciante.",
                    'precio' => rand(5, 75) + 0.99,
                    'stock' => rand(20, 100),
                    'imagen' => "https://picsum.photos/id/" . (($i * 4) + $p + 200) . "/400/400", // Foto cuadrada del producto
                    'categoria' => $sector,
                    'disponible' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Asociar 2 etiquetas aleatorias al producto (tabla pivote 'producto_etiqueta')
                $etiquetasClavesAzar = (array) array_rand($etiquetasIds, 2);
                foreach ($etiquetasClavesAzar as $clave) {
                    DB::table('producto_etiqueta')->insert([
                        'producto_id' => $productoId,
                        'etiqueta_id' => $etiquetasIds[$clave],
                    ]);
                }

                // F. Crear las Variantes del producto (tabla 'producto_variantes')
                // Decidimos de forma aleatoria si el producto tiene variantes de Talla o de Color
                $esRopa = (rand(0, 1) === 0);
                $tipoVariante = $esRopa ? 'Talla' : 'Color';
                $valores = $esRopa ? ['S', 'M', 'L', 'XL'] : ['Rojo', 'Azul', 'Verde'];

                foreach ($valores as $valor) {
                    DB::table('producto_variantes')->insert([
                        'producto_id' => $productoId,
                        'tipo' => $tipoVariante,
                        'nombre_valor' => $valor,
                        'stock' => rand(5, 30),
                        'precio_especial' => (rand(1, 4) === 1) ? (rand(10, 80) + 0.99) : null, // Algunas variantes tienen precio propio
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}

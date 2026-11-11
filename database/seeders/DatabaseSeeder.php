<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Usuarios por Rol
        $admin = User::firstOrCreate(
            ['email' => 'admin@mimundotrenzas.com'],
            [
                'name' => 'Carla Gómez (Administradora)',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'phone' => '+58 414 1112233',
                'address' => 'Sede Principal - Mi Mundo Mis Trenzas',
                'bio' => 'Fundadora y directora general de Mi Mundo Mis Trenzas.',
                'is_active' => true,
            ]
        );

        $stylist1 = User::firstOrCreate(
            ['email' => 'yomaira@mimundotrenzas.com'],
            [
                'name' => 'Yomaira Martínez',
                'password' => Hash::make('password'),
                'role' => UserRole::Stylist,
                'phone' => '+58 424 5556677',
                'address' => 'Zona Norte, Cobertura a Domicilio',
                'bio' => 'Especialista en Knotless Braids y Trenzas Fulani. 7 años creando estilos protectores.',
                'is_active' => true,
            ]
        );

        $stylist2 = User::firstOrCreate(
            ['email' => 'sofia@mimundotrenzas.com'],
            [
                'name' => 'Sofía Valderrama',
                'password' => Hash::make('password'),
                'role' => UserRole::Stylist,
                'phone' => '+58 412 8889900',
                'address' => 'Zona Este y Centro, Cobertura a Domicilio',
                'bio' => 'Experta en Box Braids clásicas, Twists Senegaleses y peinados para eventos.',
                'is_active' => true,
            ]
        );

        $client1 = User::firstOrCreate(
            ['email' => 'cliente@ejemplo.com'],
            [
                'name' => 'Valeria Morales',
                'password' => Hash::make('password'),
                'role' => UserRole::Client,
                'phone' => '+58 412 1234567',
                'address' => 'Av. Libertador, Conjunto Residencial Los Rosales, Torre B, Apto 4-B',
                'bio' => null,
                'is_active' => true,
            ]
        );

        // 2. Catálogo de Servicios de Peinados y Trenzas
        $servicesData = [
            [
                'name' => 'Trenzas Africanas Box Braids',
                'slug' => 'trenzas-africanas-box-braids',
                'category' => 'Tradicionales',
                'description' => 'Trenzas clásicas de tres cabos divididas en secciones limpias y cuadradas. Duraderas, elegantes y con acabado liviano y sellado en agua caliente.',
                'price' => 45.00,
                'estimated_duration_minutes' => 240,
                'image_url' => 'https://images.unsplash.com/photo-1605497788044-5a32c7078486?auto=format&fit=crop&w=800&q=80',
                'includes_extensions' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Knotless Braids (Sin Nudo)',
                'slug' => 'knotless-braids-sin-nudo',
                'category' => 'Modernas',
                'description' => 'Técnica moderna donde las extensiones se alimentan progresivamente sin nudo en la raíz. Cero tensión en el cuero cabelludo, movimiento natural e hiperrealista.',
                'price' => 55.00,
                'estimated_duration_minutes' => 270,
                'image_url' => 'https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?auto=format&fit=crop&w=800&q=80',
                'includes_extensions' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Trenzas Pegadas / Cornrows de Diseño',
                'slug' => 'trenzas-pegadas-cornrows-diseno',
                'category' => 'Diseño',
                'description' => 'Patrones artísticos y líneas pegadas al cuero cabelludo. Diseños curvos, zig-zag o clásicos rectos ideales para estilo diario o deportivo.',
                'price' => 35.00,
                'estimated_duration_minutes' => 120,
                'image_url' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&w=800&q=80',
                'includes_extensions' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Trenzas Fulani con Cuentas y Accesorios',
                'slug' => 'trenzas-fulani-accesorios',
                'category' => 'Étnicas',
                'description' => 'Combinación espectacular de trenza central, trenzas laterales hacia adelante y hacia atrás, adornadas con aros dorados, perlas o cuentas de madera.',
                'price' => 50.00,
                'estimated_duration_minutes' => 210,
                'image_url' => 'https://images.unsplash.com/photo-1580618672591-eb180b1a973f?auto=format&fit=crop&w=800&q=80',
                'includes_extensions' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Twists Senegaleses / Torcidos Suaves',
                'slug' => 'twists-senegaleses-torcidos',
                'category' => 'Twists',
                'description' => 'Trenzado en espiral de dos mechones con fibra suave. Look pulido, sedoso y muy sofisticado tanto para el día a día como para ocasiones especiales.',
                'price' => 48.00,
                'estimated_duration_minutes' => 220,
                'image_url' => 'https://images.unsplash.com/photo-1584297091622-af8e5fdcf040?auto=format&fit=crop&w=800&q=80',
                'includes_extensions' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Peinado Nupcial / Fiesta con Semirecogido y Trenzas',
                'slug' => 'peinado-nupcial-fiesta-trenzas',
                'category' => 'Eventos',
                'description' => 'Peinado formal a domicilio para novias, quinceañeras o eventos especiales con ondas de agua, trenzas laterales desestructuradas y fijación duradera.',
                'price' => 60.00,
                'estimated_duration_minutes' => 150,
                'image_url' => 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?auto=format&fit=crop&w=800&q=80',
                'includes_extensions' => false,
                'is_active' => true,
            ],
        ];

        $createdServices = [];
        foreach ($servicesData as $item) {
            $createdServices[] = Service::firstOrCreate(['slug' => $item['slug']], $item);
        }

        // 3. Citas de prueba
        if (Appointment::count() === 0) {
            $appointment1 = Appointment::create([
                'appointment_code' => 'TRZ-'.strtoupper(Str::random(6)),
                'client_id' => $client1->id,
                'stylist_id' => $stylist1->id,
                'service_id' => $createdServices[1]->id, // Knotless
                'scheduled_at' => now()->addDays(2)->setHour(10)->setMinute(0),
                'status' => AppointmentStatus::Confirmed,
                'total_price' => $createdServices[1]->price,
                'address' => $client1->address,
                'zone' => 'Zona Norte',
                'client_phone' => $client1->phone,
                'hair_details' => 'Cabello largo medio, deseo extensiones tono #1B castaño oscuro.',
                'notes' => 'Tocar intercomunicador 4B, hay ascensor disponible.',
            ]);

            $appointment2 = Appointment::create([
                'appointment_code' => 'TRZ-'.strtoupper(Str::random(6)),
                'client_id' => $client1->id,
                'stylist_id' => null,
                'service_id' => $createdServices[2]->id, // Cornrows
                'scheduled_at' => now()->addDays(5)->setHour(14)->setMinute(30),
                'status' => AppointmentStatus::Pending,
                'total_price' => $createdServices[2]->price,
                'address' => $client1->address,
                'zone' => 'Zona Norte',
                'client_phone' => $client1->phone,
                'hair_details' => 'Deseo diseño en espiral pegado hacia atrás.',
                'notes' => 'Disponibilidad a partir de las 2:00 PM.',
            ]);

            $completedAppointment = Appointment::create([
                'appointment_code' => 'TRZ-'.strtoupper(Str::random(6)),
                'client_id' => $client1->id,
                'stylist_id' => $stylist1->id,
                'service_id' => $createdServices[0]->id, // Box Braids
                'scheduled_at' => now()->subDays(10)->setHour(9)->setMinute(0),
                'status' => AppointmentStatus::Completed,
                'total_price' => $createdServices[0]->price,
                'address' => $client1->address,
                'zone' => 'Zona Norte',
                'client_phone' => $client1->phone,
                'hair_details' => 'Box braids tamaño medio a la cintura.',
                'notes' => 'Servicio realizado con éxito a domicilio.',
                'completed_at' => now()->subDays(10)->setHour(13)->setMinute(30),
            ]);

            Review::create([
                'appointment_id' => $completedAppointment->id,
                'client_id' => $client1->id,
                'stylist_id' => $stylist1->id,
                'rating' => 5,
                'comment' => '¡Increíble atención a domicilio! Yomaira fue súper puntual, cuidadosa con mi cabello y las trenzas quedaron espectaculares y sin dolor.',
            ]);
        }
    }
}

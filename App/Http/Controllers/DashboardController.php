<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the appropriate dashboard based on the authenticated user's role.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard($request);
        }

        if ($user->isStylist()) {
            return $this->stylistDashboard($user);
        }

        return $this->clientDashboard($user);
    }

    /**
     * Dashboard view for administrators.
     */
    private function adminDashboard(Request $request): View
    {
        $startOfWeek = now()->startOfWeek(CarbonInterface::MONDAY);

        $weeklyRevenueUsd = (float) Appointment::where('status', AppointmentStatus::Completed)
            ->where(function (Builder $query) use ($startOfWeek) {
                $query->where('completed_at', '>=', $startOfWeek)
                    ->orWhere(function (Builder $q) use ($startOfWeek) {
                        $q->whereNull('completed_at')
                            ->where('updated_at', '>=', $startOfWeek);
                    });
            })
            ->sum('total_price');

        $exchangeRate = (float) config('services.bcv.usd_rate', 60.00);
        $weeklyRevenueVes = round($weeklyRevenueUsd * $exchangeRate, 2);

        $metrics = [
            'total_appointments' => Appointment::count(),
            'pending_appointments' => Appointment::where('status', AppointmentStatus::Pending)->count(),
            'cancelled_appointments' => Appointment::where('status', AppointmentStatus::Cancelled)->count(),
            'weekly_revenue_usd' => $weeklyRevenueUsd,
            'weekly_revenue_ves' => $weeklyRevenueVes,
            'exchange_rate_ves' => $exchangeRate,
            'confirmed_appointments' => Appointment::where('status', AppointmentStatus::Confirmed)->count(),
            'completed_appointments' => Appointment::where('status', AppointmentStatus::Completed)->count(),
            'total_revenue' => Appointment::where('status', AppointmentStatus::Completed)->sum('total_price'),
            'total_clients' => User::where('role', UserRole::Client)->count(),
            'total_stylists' => User::where('role', UserRole::Stylist)->count(),
            'total_services' => Service::where('is_active', true)->count(),
        ];

        $appointments = Appointment::with(['client', 'stylist', 'service'])
            ->latest('scheduled_at')
            ->paginate(12);

        $stylists = User::where('role', UserRole::Stylist)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // Catálogo de servicios: orden, dirección y estado se resuelven por
        // lista blanca; el valor de la petición nunca pasa directo a orderBy().
        $serviceOrdenes = [
            'nombre' => 'name',
            'precio' => 'price',
            'reciente' => 'created_at',
        ];

        $ordenSolicitado = $request->query('orden');
        $serviceOrden = array_key_exists($ordenSolicitado, $serviceOrdenes)
            ? $ordenSolicitado
            : 'reciente';

        $direccionSolicitada = $request->query('direccion');
        $serviceDireccion = in_array($direccionSolicitada, ['asc', 'desc'], true)
            ? $direccionSolicitada
            : ($serviceOrdenes[$serviceOrden] === 'created_at' ? 'desc' : 'asc');

        $estadoSolicitado = $request->query('estado');
        $serviceEstado = in_array($estadoSolicitado, ['todos', 'activos', 'inactivos'], true)
            ? $estadoSolicitado
            : 'todos';

        $services = Service::query()
            ->when($serviceEstado === 'activos', fn (Builder $query) => $query->where('is_active', true))
            ->when($serviceEstado === 'inactivos', fn (Builder $query) => $query->where('is_active', false))
            ->orderBy($serviceOrdenes[$serviceOrden], $serviceDireccion)
            ->orderBy('id', $serviceDireccion)
            ->paginate(6)
            ->withQueryString();

        $data = compact('metrics', 'appointments', 'stylists', 'services', 'serviceOrden', 'serviceDireccion', 'serviceEstado');

        // El catálogo pide su fragmento por encabezado para actualizarse sin
        // recargar la página; así la URL y los links del paginador se mantienen
        // canónicos, sin parámetros técnicos en la query.
        if ($request->header('X-Fragmento') === 'servicios') {
            return view('dashboard.partials.servicios', $data);
        }

        return view('dashboard.admin', $data);
    }

    /**
     * Dashboard view for home stylists.
     */
    private function stylistDashboard(User $user): View
    {
        $todayAppointments = Appointment::with(['client', 'service'])
            ->where('stylist_id', $user->id)
            ->whereDate('scheduled_at', today())
            ->orderBy('scheduled_at')
            ->get();

        $upcomingAppointments = Appointment::with(['client', 'service'])
            ->where('stylist_id', $user->id)
            ->where('scheduled_at', '>=', now())
            ->whereIn('status', [AppointmentStatus::Confirmed, AppointmentStatus::InProgress])
            ->orderBy('scheduled_at')
            ->get();

        $completedAppointments = Appointment::with(['client', 'service', 'review'])
            ->where('stylist_id', $user->id)
            ->where('status', AppointmentStatus::Completed)
            ->latest('completed_at')
            ->take(10)
            ->get();

        $metrics = [
            'today_count' => $todayAppointments->count(),
            'upcoming_count' => $upcomingAppointments->count(),
            'completed_count' => Appointment::where('stylist_id', $user->id)->where('status', AppointmentStatus::Completed)->count(),
            'average_rating' => round(Review::where('stylist_id', $user->id)->avg('rating') ?? 5.0, 1),
            'reviews_count' => Review::where('stylist_id', $user->id)->count(),
        ];

        return view('dashboard.stylist', compact('user', 'todayAppointments', 'upcomingAppointments', 'completedAppointments', 'metrics'));
    }

    /**
     * Dashboard view for clients.
     */
    private function clientDashboard(User $user): View
    {
        $activeAppointments = Appointment::with(['service', 'stylist'])
            ->where('client_id', $user->id)
            ->whereIn('status', [AppointmentStatus::Pending, AppointmentStatus::Confirmed, AppointmentStatus::InProgress])
            ->orderBy('scheduled_at')
            ->get();

        $historyAppointments = Appointment::with(['service', 'stylist', 'review'])
            ->where('client_id', $user->id)
            ->whereIn('status', [AppointmentStatus::Completed, AppointmentStatus::Cancelled])
            ->latest('scheduled_at')
            ->take(10)
            ->get();

        $availableServices = Service::where('is_active', true)->orderBy('name')->get();

        return view('dashboard.client', compact('user', 'activeAppointments', 'historyAppointments', 'availableServices'));
    }
}

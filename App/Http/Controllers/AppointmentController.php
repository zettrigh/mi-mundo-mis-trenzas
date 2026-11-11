<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    /**
     * Store a new appointment requested by a client.
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'scheduled_at' => ['required', 'date', 'after:now'],
            'address' => ['required', 'string', 'max:500'],
            'zone' => ['nullable', 'string', 'max:100'],
            'client_phone' => ['required', 'string', 'max:30'],
            'hair_details' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $service = Service::findOrFail($validated['service_id']);

        $appointment = Appointment::create([
            'appointment_code' => 'TRZ-'.strtoupper(Str::random(6)),
            'client_id' => $user->id,
            'stylist_id' => null,
            'service_id' => $service->id,
            'scheduled_at' => $validated['scheduled_at'],
            'status' => AppointmentStatus::Pending,
            'total_price' => $service->price,
            'address' => $validated['address'],
            'zone' => $validated['zone'],
            'client_phone' => $validated['client_phone'],
            'hair_details' => $validated['hair_details'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        if (blank($user->phone) || blank($user->address)) {
            $user->update([
                'phone' => $user->phone ?? $validated['client_phone'],
                'address' => $user->address ?? $validated['address'],
            ]);
        }

        return redirect()->route('dashboard')
            ->with('status', "¡Tu cita a domicilio (#{$appointment->appointment_code}) fue agendada exitosamente! Nos comunicaremos contigo para confirmar la visita.");
    }

    /**
     * Cancel an appointment.
     */
    public function cancel(Request $request, Appointment $appointment): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isAdmin() && $appointment->client_id !== $user->id) {
            abort(403, 'No tienes autorización para cancelar esta cita.');
        }

        $validated = $request->validate([
            'cancellation_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $appointment->update([
            'status' => AppointmentStatus::Cancelled,
            'cancellation_reason' => $validated['cancellation_reason'] ?? 'Cancelado por el usuario.',
        ]);

        return redirect()->back()
            ->with('status', "La cita #{$appointment->appointment_code} ha sido cancelada.");
    }

    /**
     * Update appointment status and stylist assignment by Admin.
     */
    public function updateByAdmin(Request $request, Appointment $appointment): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->isAdmin()) {
            abort(403, 'Acción restringida a administradores.');
        }

        $validated = $request->validate([
            'status' => ['required', Rule::enum(AppointmentStatus::class)],
            'stylist_id' => ['nullable', 'exists:users,id'],
        ]);

        $updateData = [
            'status' => $validated['status'],
            'stylist_id' => $validated['stylist_id'] ?: null,
        ];

        if ($validated['status'] === AppointmentStatus::Completed->value && is_null($appointment->completed_at)) {
            $updateData['completed_at'] = now();
        }

        $appointment->update($updateData);

        return redirect()->back()
            ->with('status', "Cita #{$appointment->appointment_code} actualizada correctamente.");
    }

    /**
     * Update appointment status by Stylist.
     */
    public function updateStatusByStylist(Request $request, Appointment $appointment): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($appointment->stylist_id !== $user->id) {
            abort(403, 'Esta cita no está asignada a tu usuario.');
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in([
                AppointmentStatus::InProgress->value,
                AppointmentStatus::Completed->value,
            ])],
        ]);

        $updateData = ['status' => $validated['status']];

        if ($validated['status'] === AppointmentStatus::Completed->value) {
            $updateData['completed_at'] = now();
        }

        $appointment->update($updateData);

        return redirect()->back()
            ->with('status', "Estado de la cita #{$appointment->appointment_code} actualizado a {$appointment->status->label()}.");
    }

    /**
     * Store review for a completed appointment.
     */
    public function storeReview(Request $request, Appointment $appointment): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($appointment->client_id !== $user->id) {
            abort(403, 'No puedes calificar una cita ajena.');
        }

        if ($appointment->status !== AppointmentStatus::Completed) {
            return redirect()->back()->withErrors(['review' => 'Solo puedes calificar citas completadas.']);
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        Review::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'client_id' => $user->id,
                'stylist_id' => $appointment->stylist_id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        return redirect()->back()
            ->with('status', '¡Muchas gracias por calificar nuestro servicio a domicilio!');
    }
}

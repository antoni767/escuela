<?php

namespace App\Filament\Resources\AlumnoResource\Pages;

use App\Filament\Resources\AlumnoResource;
use App\Models\Tutor;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateAlumno extends CreateRecord
{
    protected static string $resource = AlumnoResource::class;

    /**
     * Intercepta el proceso de creación para asegurar que tutor_id esté asignado.
     */
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // 1️⃣ Validar que haya un tutor
        if (empty($data['tutor_id']) && empty($data['crear_tutor_manual'])) {
            Notification::make()
                ->danger()
                ->title('Error')
                ->body('Debes seleccionar o crear un tutor antes de guardar.')
                ->send();

            throw new \Filament\Forms\FormValidationException();
        }

        // 2️⃣ Si el usuario creó un tutor manualmente, lo guardamos primero
        if (!empty($data['crear_tutor_manual'])) {
            $nuevoTutor = Tutor::create([
                'nombre' => $data['tutor_nombre_manual'],
                'telefono' => $data['tutor_telefono_manual'],
            ]);

            // Asignamos el ID del nuevo tutor al alumno
            $data['tutor_id'] = $nuevoTutor->id;
        }

        // 3️⃣ Llamamos al método padre para crear el alumno
        $alumno = parent::handleRecordCreation($data);

        // 4️⃣ Mostrar notificación de éxito
        Notification::make()
            ->success()
            ->title('¡Éxito!')
            ->body('¡Se ha registrado el alumno exitosamente!')
            ->send();

        return $alumno;
    }

    /**
     * Personaliza la notificación de creación (opcional)
     */
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('¡Éxito!')
            ->body('El registro del alumno se ha realizado correctamente.')
            ->icon('heroicon-s-check')
            ->iconColor('text-green-500')
            ->iconSize('h-6 w-6')
            ->iconPosition('before');
    }

    /**
     * Redirige al listado de alumnos después de guardar
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

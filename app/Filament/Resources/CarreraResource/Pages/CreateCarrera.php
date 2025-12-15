<?php

namespace App\Filament\Resources\CarreraResource\Pages;

use App\Filament\Resources\CarreraResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Filament\Actions\Action;

class CreateCarrera extends CreateRecord
{
    protected static string $resource = CarreraResource::class;

    /**
     * Notificación personalizada al crear el registro.
     */
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('¡Éxito!')
            ->body('El registro de carrera se ha realizado exitosamente')
            ->icon('heroicon-s-check')
            ->iconColor('text-green-500')
            ->iconSize('h-6 w-6')
            ->iconPosition('before');
    }

    /**
     * Redirige al listado de carreras después de guardar.
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    /**
     * Personaliza los botones del formulario: texto, color e icono.
     */
    protected function getFormActions(): array
    {
        return [
            // Botón "Crear"
            Action::make('create')
                ->label('Guardar')
                ->icon('heroicon-o-document-plus')  // icono de guardar (outline)
                ->color('success'),          // azul

            // Botón "Crear y crear otro"
            /**Action::make('createAnother')
                ->label('Crear y crear otro')
                ->icon('heroicon-o-plus')   // icono de más (outline)
                ->color('success'),    */      // verde

            // Botón "Cancelar"
            Action::make('cancel')
                ->label('Cancelar')
                ->icon('heroicon-o-x-mark') // icono de X (outline)
                ->color('danger')            // rojo
                ->url($this->getResource()::getUrl('index')),
        ];
    }
}

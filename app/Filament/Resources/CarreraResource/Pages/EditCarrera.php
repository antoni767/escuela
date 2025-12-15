<?php

namespace App\Filament\Resources\CarreraResource\Pages;

use App\Filament\Resources\CarreraResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditCarrera extends EditRecord
{
    protected static string $resource = CarreraResource::class;

    /**
     * Reemplaza la notificación predeterminada de guardado.
     */
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('¡Éxito!')
            ->body('El registro se modificó correctamente')
            ->icon('heroicon-s-check') // sólido, check
            ->iconColor('text-green-500')
            ->iconSize('h-6 w-6')
            ->iconPosition('before');
    }
}


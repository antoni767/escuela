<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Support\HtmlString;

class Login extends BaseLogin
{
    /**
     * Quitar el título del login
     */
    public function getHeading(): HtmlString|string
    {
        return ''; // string vacío para que no se muestre
    }

    /**
     * Quitar el logo predeterminado
     */
    protected function getLogo(): ?string
    {
        return null; // null hace que no aparezca el logo
    }
}

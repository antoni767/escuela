<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TutorResource\Pages;
use App\Models\Tutor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;

class TutorResource extends Resource
{
    protected static ?string $model = Tutor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Tutores';
    protected static ?string $navigationGroup = 'Gestión Escolar';
    protected static ?int $navigationSort = 1;

    /* ==========================
     * FORMULARIO PREMIUM
     * ========================== */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos del Tutor')
                    ->description('Información de contacto del tutor')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre completo')
                            ->placeholder('Ej. Juan Pérez López')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-user')
                            ->helperText('Nombre del tutor responsable'),

Forms\Components\TextInput::make('telefono')
    ->label('Teléfono')
    ->placeholder('9581234567')
    ->required()
    ->tel()
    ->rule('digits:10')       // Backend: exactamente 10
    ->minLength(10)
    ->maxLength(10)           // Frontend: no deja escribir más
    ->regex('/^[0-9]{10}$/')  // Solo números
    ->extraInputAttributes([
        'inputmode' => 'numeric', // Móvil
        'pattern' => '[0-9]{10}', // Solo números
        'maxlength' => 10,        // 🔒 HTML real
        'oninput' => "this.value = this.value.replace(/[^0-9]/g,'').slice(0,10);",
    ])
    ->prefixIcon('heroicon-o-phone')
    ->helperText('Ingrese exactamente 10 dígitos')
    ->unique(ignoreRecord: true),

                    ])
                    ->columns(2)
                    ->collapsible(),
            ]);
    }

    /* ==========================
     * TABLA SIMPLE (solo visual)
     * ========================== */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Tutor')
                    ->icon('heroicon-o-user-circle')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold),

                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->icon('heroicon-o-phone'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->color('danger'),
            ])
            ->emptyStateHeading('No hay tutores registrados')
            ->emptyStateDescription('Registra el primer tutor')
            ->emptyStateIcon('heroicon-o-user-group');
    }

    /* ==========================
     * PÁGINAS
     * ========================== */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTutors::route('/'),
            'create' => Pages\CreateTutor::route('/create'),
            'edit' => Pages\EditTutor::route('/{record}/edit'),
        ];
    }
}

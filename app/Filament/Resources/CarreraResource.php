<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarreraResource\Pages;
use App\Models\Carrera;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;

class CarreraResource extends Resource
{
    protected static ?string $model = Carrera::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Carreras';
    protected static ?string $navigationGroup = 'Catálogos';
    protected static ?int $navigationSort = 1;

    /* ==================================
     * FORMULARIO
     * ================================== */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de la carrera')
                    ->description('Registra el nombre de la carrera académica')
                    ->icon('heroicon-o-book-open')
                    ->schema([
                        Forms\Components\TextInput::make('nombre')
                            ->label('Nombre de la carrera')
                            ->placeholder('Ej. Ingeniería en Sistemas Computacionales')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-academic-cap')
                            ->helperText('Este nombre será visible en todo el sistema'),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    /* ==================================
     * TABLA
     * ================================== */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Carrera')
                    ->icon('heroicon-o-academic-cap')
                    ->iconPosition('before')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold)
                    ->wrap(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registrado')
                    ->date('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-eye')
                    ->color('gray'),

                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->color('primary')
                    ->modalHeading('Editar carrera')
                    ->modalSubmitActionLabel('Guardar cambios'),

                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->modalHeading('Eliminar carrera')
                    ->modalDescription('¿Estás seguro de eliminar esta carrera? Esta acción no se puede deshacer.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->icon('heroicon-o-trash')
                        ->color('danger'),
                ]),
            ])
            ->emptyStateHeading('No hay carreras registradas')
            ->emptyStateDescription('Comienza registrando una nueva carrera académica')
            ->emptyStateIcon('heroicon-o-academic-cap')
            ->defaultSort('nombre');
    }

    /* ==================================
     * RELACIONES
     * ================================== */
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /* ==================================
     * PÁGINAS
     * ================================== */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarreras::route('/'),
            'create' => Pages\CreateCarrera::route('/create'),
            'edit' => Pages\EditCarrera::route('/{record}/edit'),
        ];
    }
}


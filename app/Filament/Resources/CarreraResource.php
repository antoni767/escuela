<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarreraResource\Pages;
use App\Models\Carrera;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CarreraResource extends Resource
{
    protected static ?string $model = Carrera::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap'; // Icono más representativo
    protected static ?string $navigationLabel = 'Carreras';

    /* ==================================
     * FORMULARIO
     * ================================== */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre de la carrera')
                    ->placeholder('Ingrese el nombre de la carrera')
                    ->required()
                    ->maxLength(255)
                    ->prefixIcon('heroicon-o-book-open'), // Icono dentro del input
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
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-academic-cap', 'before'), // Icono antes del texto
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil') // Icono del botón editar
                    ->button()
                    ->color('primary'),
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->button()
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->icon('heroicon-o-trash')
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('nombre', 'asc');
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

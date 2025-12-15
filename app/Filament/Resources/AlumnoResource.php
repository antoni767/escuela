<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlumnoResource\Pages;
use App\Models\Alumno;
use App\Models\Tutor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Carbon\Carbon;

class AlumnoResource extends Resource
{
    protected static ?string $model = Alumno::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Alumnos';
    protected static ?string $pluralLabel = 'Alumnos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                /* ==================================
                 * DATOS DEL ALUMNO
                 * ================================== */
                Forms\Components\Section::make('Datos del Alumno')
                    ->schema([

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('nombre_completo')
                                    ->label('Nombre completo')
                                    ->required()
                                    ->prefixIcon('heroicon-m-user'),

                                Forms\Components\ToggleButtons::make('sexo')
                                    ->label('Sexo')
                                    ->options([
                                        'M' => 'Masculino',
                                        'F' => 'Femenino',
                                    ])
                                    ->icons([
                                        'M' => 'heroicon-m-user',
                                        'F' => 'heroicon-m-user',
                                    ])
                                    ->required()
                                    ->grouped()
                                    ->inline()
                                    ->default('M'),
                            ]),

                        Forms\Components\Select::make('carrera_id')
                            ->label('Carrera')
                            ->relationship('carrera', 'nombre')
                            ->searchable()
                            ->required()
                            ->prefixIcon('heroicon-m-academic-cap'),

                        /*  ❗ QUITAMOS EL CAMPO DE SEMESTRE
                            AHORA SE CALCULA AUTOMÁTICAMENTE */

                        Forms\Components\Select::make('tipo_sangre')
                            ->label('Tipo de sangre')
                            ->options([
                                'A+' => 'A+',
                                'A-' => 'A-',
                                'B+' => 'B+',
                                'B-' => 'B-',
                                'AB+' => 'AB+',
                                'AB-' => 'AB-',
                                'O+' => 'O+',
                                'O-' => 'O-',
                            ])
                            ->required()
                            ->prefixIcon('heroicon-m-heart'),

                        Forms\Components\TextInput::make('direccion')
                            ->label('Dirección')
                            ->required()
                            ->prefixIcon('heroicon-m-home'),

                        Forms\Components\TextInput::make('telefono')
                            ->label('Teléfono del alumno')
                            ->required()
                            ->tel()
                            ->prefixIcon('heroicon-m-phone'),

                        Forms\Components\TextInput::make('nss')
                            ->label('NSS')
                            ->placeholder('Número de Seguridad Social')
                            ->required()
                            ->prefixIcon('heroicon-m-identification'),

                        Forms\Components\DatePicker::make('fecha_inscripcion')
                            ->label('Fecha de inscripción')
                            ->required()
                            ->prefixIcon('heroicon-m-calendar-days'),
                    ])
                    ->columns(2),

                /* ==================================
                 * TUTOR
                 * ================================== */
                Forms\Components\Section::make('Tutor')
                    ->schema([

                        Forms\Components\Select::make('tutor_id')
                            ->label('Tutor (buscar o crear)')
                            ->relationship('tutor', 'nombre')
                            ->searchable()
                            ->reactive()
                            ->prefixIcon(null)
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state) {
                                    $tutor = Tutor::find($state);
                                    $set('tutor_telefono', $tutor?->telefono);
                                } else {
                                    $set('tutor_telefono', null);
                                }
                            })
                            ->createOptionAction(function () {
                                return Forms\Components\Actions\Action::make('crearTutor')
                                    ->label('Registrar nuevo tutor')
                                    ->form([
                                        Forms\Components\TextInput::make('nombre')
                                            ->label('Nombre')
                                            ->required(),

                                        Forms\Components\TextInput::make('telefono')
                                            ->label('Teléfono')
                                            ->required()
                                            ->tel(),
                                    ])
                                    ->action(function ($data, $set) {
                                        $nuevo = Tutor::create([
                                            'nombre' => $data['nombre'],
                                            'telefono' => $data['telefono'],
                                        ]);

                                        $set('tutor_id', $nuevo->id);
                                        $set('tutor_telefono', $nuevo->telefono);
                                    });
                            }),

                        Forms\Components\TextInput::make('tutor_telefono')
                            ->label('Teléfono del tutor')
                            ->disabled()
                            ->prefixIcon('heroicon-m-phone'),

                        Forms\Components\Checkbox::make('crear_tutor_manual')
                            ->label('Registrar tutor manualmente')
                            ->reactive(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('tutor_nombre_manual')
                                    ->label('Nombre del tutor (manual)')
                                    ->prefixIcon('heroicon-m-user')
                                    ->required(fn ($get) => $get('crear_tutor_manual')),

                                Forms\Components\TextInput::make('tutor_telefono_manual')
                                    ->label('Teléfono del tutor (manual)')
                                    ->tel()
                                    ->prefixIcon('heroicon-m-phone')
                                    ->required(fn ($get) => $get('crear_tutor_manual')),
                            ])
                            ->visible(fn ($get) => $get('crear_tutor_manual')),
                    ])
                    ->columns(2),
            ]);
    }

    /* ==================================
     * TABLA LISTADO
     * ================================== */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_completo')
                    ->label('Alumno')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('carrera.nombre')
                    ->label('Carrera'),

                // 🔥 Mostrar semestre calculado automáticamente
                Tables\Columns\TextColumn::make('semestre')
                    ->label('Semestre')
                    ->getStateUsing(function ($record) {
                        $fecha = Carbon::parse($record->fecha_inscripcion);
                        $meses = $fecha->diffInMonths(now());
                        return floor($meses / 6) + 1;
                    }),

                Tables\Columns\TextColumn::make('tutor.nombre')
                    ->label('Tutor'),

                Tables\Columns\TextColumn::make('tutor.telefono')
                ->label('Telefono'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    /* ==================================
     * PÁGINAS
     * ================================== */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlumnos::route('/'),
            'create' => Pages\CreateAlumno::route('/create'),
            'edit' => Pages\EditAlumno::route('/{record}/edit'),
        ];
    }
}

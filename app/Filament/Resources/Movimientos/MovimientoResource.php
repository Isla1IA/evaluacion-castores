<?php

namespace App\Filament\Resources\Movimientos;

use App\Filament\Resources\Movimientos\Pages\CreateMovimiento;
use App\Filament\Resources\Movimientos\Pages\EditMovimiento;
use App\Filament\Resources\Movimientos\Pages\ListMovimientos;
use App\Filament\Resources\Movimientos\Schemas\MovimientoForm;
use App\Filament\Resources\Movimientos\Tables\MovimientosTable;
use App\Models\Movimiento;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Actions;

class MovimientoResource extends Resource
{
    protected static ?string $model = Movimiento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MovimientoForm::configure($schema);
    }

    /**/


    public static function table(Table $table): Table
    {
        return MovimientosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        //Solo se muestra la pagina de listado, no se pueden crear o editar movimientos manualmente
        return [
            'index' => ListMovimientos::route('/'),
        ];
    }

    //Funcion para que solo el administrador pueda vea el historico de movimientos
    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }
    //Funcion para que solo el admin pueda ver en el menu el recurso de movimientos
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }
}

<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use App\Models\Producto;
use App\Models\Movimiento;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;

class SalidaProductos extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpOnSquare;
    protected string $view = 'filament.pages.salida-productos';
    protected static ?string $navigationLabel = 'Salida de productos';
    protected static ?string $title = 'Salida de productos';

    public ?int $producto_id = null;
    public ?int $cantidad = null;

    //Funcion para verificar si el usuario tiene el rol de almacenista y puede acceder a esta pagina
    public static function canAccess(): bool
    {
        return auth()->user()?->isAlmacenista() ?? false;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('producto_id')
                    ->label('Producto')
                    ->options(
                        Producto::query()
                            ->where('estatus', 1)
                            ->orderBy('nombre')
                            ->pluck('nombre', 'id')
                    )
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('cantidad')
                    ->label('Cantidad a Retirar')
                    ->numeric()
                    ->required()
                    ->minValue(1),
            ]);
        //->statePath('data');
    }

    //Funcion para manejar la salida de productos
    public function retirar(): void
    {
        $productoId = (int) ($this->producto_id ?? 0);
        $qty = (int) ($this->cantidad ?? 0);

        if ($productoId <= 0 || $qty <= 0) {
            Notification::make()
                ->title('Datos inválidos')
                ->danger()
                ->send();
            return;
        }

        DB::transaction(function () use ($productoId, $qty) {
            $producto = Producto::lockForUpdate()->findOrFail($productoId);

            if (!$producto->estatus) {
                Notification::make()
                    ->title('Producto Inactivo')
                    ->body("El producto {$producto->nombre} no está disponible.")
                    ->danger()
                    ->send();
                return;
            }

            if ($qty > $producto->cantidad) {
                Notification::make()
                    ->title('Stock Insuficiente')
                    ->body("No hay suficientes unidades de {$producto->nombre} para retirar. Stock actual: {$producto->cantidad}.")
                    ->danger()
                    ->send();
                return;
            }

            //Resta del inventario
            $producto->decrement('cantidad', $qty);

            //Registrar Movimiento
            Movimiento::create([
                'user_id' => auth()->id(),
                'producto_id' => $producto->id,
                'tipo' => 'salida',
                'cantidad' => $qty,
            ]);

            //Notificacion de exito
            Notification::make()
                ->title('Salida Registrada')
                ->body("Se han retirado {$qty} unidades de {$producto->nombre}.")
                ->success()
                ->send();

            //Limpieza de datos del formulario
            $this->producto_id = null;
            $this->cantidad = null;
        });
    }
}

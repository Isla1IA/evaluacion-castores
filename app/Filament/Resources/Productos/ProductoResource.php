<?php

namespace App\Filament\Resources\Productos;

use App\Filament\Resources\Productos\Pages\CreateProducto;
use App\Filament\Resources\Productos\Pages\EditProducto;
use App\Filament\Resources\Productos\Pages\ListProductos;
use App\Filament\Resources\Productos\Schemas\ProductoForm;
use App\Filament\Resources\Productos\Tables\ProductosTable;
use App\Models\Producto;
use BackedEnum;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms; //Es importante para que funcione el Forms\Components\TextInput
use Filament\Tables; //Es importante para que funcione el Tables\Columns\TextColumn
//use Filament\Tables\Actions\Action;
//use Filament\Tables\Actions\EditAction; //Es importante para que funcione el EditAction
use App\Models\Movimiento;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Actions\CreateAction;



use Filament\Forms\Components\TextInput;

use Filament\Notifications\Notification;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    //Formulario para crear y editar productos
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cantidad')
                    ->numeric()
                    ->disabled() //No se puede editar la cantidad directamente, solo a través de movimientos
                    ->dehydrated(false) //No se guarda en la base de datos, solo se muestra en el formulario
                    ->default(0),
                Forms\Components\Toggle::make('estatus')
                    ->label('Activo')
                    ->default(true),
            ]);
    }
    //Como se muestra en la tabla de productos
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->searchable(),
                Tables\Columns\TextColumn::make('cantidad')->sortable(),
                Tables\Columns\IconColumn::make('estatus')
                    ->boolean()
                    ->label('Activo'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Actualizado'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('estatus')
                    ->label('Estatus')
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos'),
            ])
            ->headerActions([
                //EditAction::make(),
                Action::make('entrada')
                    ->label('Agregar Existencias')
                    ->form([
                        Select::make('producto_id')
                            ->label('Producto')
                            ->options(
                                Producto::query()
                                    ->orderBy('nombre')
                                    ->pluck('nombre', 'id')
                            )
                            ->searchable()
                            ->required(),
                        TextInput::make('cantidad')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                    ])
                    ->action(function (array $data) {

                        $productoId = (int) ($data['producto_id'] ?? 0);
                        $qty = (int) ($data['cantidad'] ?? 0);
                        $producto = Producto::findOrFail($productoId);

                        //Suma de inventario
                        $producto->increment('cantidad', $qty);
                        //Registro del movimiento
                        Movimiento::create([
                            'user_id' => auth()->id(),
                            'producto_id' => $producto->id,
                            'tipo' => 'entrada',
                            'cantidad' => $qty,
                        ]);

                        //Notificacion de exito
                        Notification::make()
                            ->title('Inventario Actualizado')
                            ->body("Se han agregado {$qty} unidades a {$producto->nombre}.")
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductos::route('/'),
            'create' => CreateProducto::route('/create'),
            'edit' => EditProducto::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }
}

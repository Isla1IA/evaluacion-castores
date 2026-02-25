<?php

namespace App\Filament\Resources\Movimientos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables;

class MovimientosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('producto.nombre')
                    ->label('Producto')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge(),

                Tables\Columns\TextColumn::make('cantidad')
                    ->label('Cantidad')
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipo')
                    ->options([
                        'entrada' => 'Entrada',
                        'salida' => 'Salida',
                    ])
                    ->placeholder('Todos los tipos'),
            ])
            ->actions([]) //No se pueden editar movimientos manualmente
            ->toolbarActions([])  //Sin acciones masivas en la tabla
            ->headerActions([]); //Sin acciones en el encabezado
    }
}

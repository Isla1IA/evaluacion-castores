<x-filament-panels::page>
    {{-- Page content --}}
    <div class="space-y-6">
        {{ $this->form }}

        <x-filament::button wire:click="retirar" color="danger">
            Retirar Producto del Inventario
        </x-filament::button>

    </div>
</x-filament-panels::page>

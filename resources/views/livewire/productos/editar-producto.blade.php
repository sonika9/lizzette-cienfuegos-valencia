<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Productos') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form wire:submit="editarProducto">
                    <h2>Editar Producto</h2>
                    @include('livewire.productos.producto-form')
                    <div class="flex justify-end mt-4">
                        <button class="ml-3 font-medium text-sm flex bg-blue-100 hover:bg-blue-200 rounded-md px-3 py-1.5" type="submit">Editar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

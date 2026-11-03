<div class="mx-auto max-w-6xl space-y-6 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Reporte de pedidos</h1>
        </div>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="mb-4">
            <label for="busqueda"
                   class="mb-1.5 block text-sm font-medium text-gray-700">
                Buscar Pedidos
            </label>
            Del
            <input class="rounded-md border border-gray-300" type="date"
                   wire:model.live.debounce.500ms="fechaInicio">
            Al
            <input class="rounded-md border border-gray-300" type="date"
                   wire:model.live.debounce.500ms="fechaFin">
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-1">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
                    <h2 class="font-semibold text-gray-900">Pedidos</h2>

                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                        {{ $pedidos->count() }} resultados
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-5 py-3 font-semibold">Folio</th>
                            <th class="px-5 py-3 font-semibold">Email</th>
                            <th class="px-5 py-3 font-semibold">Total</th>
                            <th class="px-5 py-3 font-semibold">Estatus</th>
                            <th class="px-5 py-3 font-semibold">Fecha</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @forelse ($pedidos as $pedido)
                            <tr wire:key="pedido-{{ $pedido->id }}"
                                class="transition hover:bg-gray-50">

                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $pedido->folio }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $pedido->email }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $pedido->total }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $pedido->estatus }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $pedido->fecha }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center">
                                    <p class="font-medium text-gray-700">
                                        No se encontraron pedidos
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $pedidos->links() }}
            </div>
        </div>
    </div>
</div>

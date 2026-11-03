<div class="mx-auto max-w-6xl space-y-6 p-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Lista de Productos</h1>

            <p class="mt-1 text-sm text-gray-500">
                Administrar lista de productos
            </p>
        </div>
        <a href="{{ route('productos.crear') }}"
           class="ml-3 font-medium text-sm flex bg-blue-100 hover:bg-blue-200 rounded-md px-3 py-1.5">
            + Agregar Producto
        </a>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
        <div class="mb-4">
            <label for="busqueda"
                   class="mb-1.5 block text-sm font-medium text-gray-700">
                Buscar Productos
            </label>
            <input
                type="text"
                wire:model.live.debounce.300ms="busqueda"
                placeholder="Buscar por nombre  o sku"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm
                           shadow-sm outline-none transition
                           placeholder:text-gray-400
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
            >
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-1">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
                    <h2 class="font-semibold text-gray-900">Productos</h2>

                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                        {{ $productos->count() }} resultados
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-5 py-3 font-semibold">SKU</th>
                            <th class="px-5 py-3 font-semibold">Nombre</th>
                            <th class="px-5 py-3 font-semibold">precio USD</th>
                            <th class="px-5 py-3 font-semibold">precio MXN</th>
                            <th class="px-5 py-3 font-semibold">Stock</th>
                            <th class="px-5 py-3 font-semibold">Activo</th>
                            <th class="px-5 py-3 font-semibold">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @forelse ($productos as $producto)
                            <tr wire:key="producto-{{ $producto->id }}"
                                class="transition hover:bg-gray-50">

                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $producto->sku }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $producto->nombre }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    ${{ number_format($producto->precio_usd, 2, '.', ',') }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    ${{ number_format($producto->precio_mxn, 2, '.', ',') }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $producto->stock }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-gray-600">
                                    {{ $producto->activo ? 'si' : 'no' }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <button
                                        type="button"
                                        title="Ver detalle"
                                        @click="$dispatch('open-producto-modal', {{ Illuminate\Support\Js::from($producto) }})"
                                        class="font-medium text-gray-700"
                                    >
                                        <i class="fas fa-eye text-xs"></i>
                                    </button>
                                    <a
                                        href="{{ route('productos.editar', $producto->id) }}"
                                        title="Editar"
                                        class="font-medium hover:underline text-blue-700"
                                    >
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <button
                                        type="button"
                                        title="Eliminar"
                                        wire:click="confirmarEliminarProducto({{ $producto->id }})"
                                        class="font-medium text-red-700"
                                    >
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                    <button
                                        type="button"
                                        title="{{ $producto->activo ? 'Desactivar' : 'Activar'  }}"
                                        wire:click="confirmarCambiarStatusProducto({{ $producto->id }}, {{ $producto->activo }})"
                                        class="font-medium"
                                    >
{{--                                        {{ $producto->activo ? 'Desactivar' : 'Activar'  }}--}}
                                        <i class="fas {{ $producto->activo ? 'fa-cancel text-red-700' : 'fa-check-circle text-green-600'  }} text-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center">
                                    <p class="font-medium text-gray-700">
                                        No se encontraron productos
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $productos->links() }}
            </div>
        </div>
    </div>

    {{--Modal del detalle del producto--}}
    <div
        x-data="{ open: false, producto: null }"
        @open-producto-modal.window="producto = $event.detail; open = true"
        @keydown.escape.window="open = false"
    >
        <div
            x-cloak
            x-show="open"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center
           bg-gray-900/60 p-4"
            @click.self="open = false"
        >
            <section
                class="w-full max-w-md rounded-2xl border border-gray-200
           bg-white p-6 shadow-2xl max-h-[90vh] overflow-y-auto"
                @click.stop
            >
                <template x-if="producto">
                    <div>
                        <div class="flex items-start justify-between">
                            <div>
                                <h2
                                    class="text-xl font-bold text-gray-900"
                                    x-text="producto.nombre"
                                ></h2>
                            </div>

                            <button
                                type="button"
                                @click="open = false"
                                class="rounded-lg px-3 py-1 text-gray-500 hover:bg-gray-100"
                                aria-label="Cerrar modal"
                            >
                                ✕
                            </button>
                        </div>

                        <div class="mt-6 space-y-4">
                            <div>
                                <p class="text-xs font-medium uppercase text-gray-500">
                                    Imagen
                                </p>
                                <template x-if="producto.imagen">
                                    <img :src="'{{ asset('storage') }}/' + producto.imagen" alt="Imagen del producto"
                                         class="w-[200px] mb-2 rounded-lg border border-gray-300 px-3 py-2"/>
                                </template>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase text-gray-500">
                                    SKU
                                </p>
                                <p
                                    class="mt-1 font-medium text-gray-900"
                                    x-text="producto.sku"
                                ></p>
                            </div>

                            <div>
                                <p class="text-xs font-medium uppercase text-gray-500">
                                    Nombre
                                </p>
                                <p
                                    class="mt-1 font-medium text-gray-900"
                                    x-text="producto.nombre"
                                ></p>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase text-gray-500">
                                    Descripcion Corta
                                </p>
                                <p
                                    class="mt-1 font-medium text-gray-900"
                                    x-text="producto.descripcion_corta"
                                ></p>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase text-gray-500">
                                    Descripcion Larga
                                </p>
                                <p
                                    class="mt-1 font-medium text-gray-900"
                                    x-text="producto.descripcion_larga"
                                ></p>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase text-gray-500">
                                    Precio USD
                                </p>
                                <p
                                    class="mt-1 font-medium text-gray-900"
                                    x-text="producto.precio_usd"
                                ></p>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase text-gray-500">
                                    Precio MXN
                                </p>
                                <p
                                    class="mt-1 font-medium text-gray-900"
                                    x-text="producto.precio_mxn"
                                ></p>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase text-gray-500">
                                    Stock
                                </p>
                                <p
                                    class="mt-1 font-medium text-gray-900"
                                    x-text="producto.stock"
                                ></p>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase text-gray-500">
                                    Fecha Vigencia
                                </p>
                                <p
                                    class="mt-1 font-medium text-gray-900"
                                    x-text="producto.fecha_vigencia"
                                ></p>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase text-gray-500">
                                    Activo
                                </p>
                                <p
                                    class="mt-1 font-medium text-gray-900"
                                    x-text="producto.activo"
                                ></p>
                            </div>
                            <div>
                                <p class="text-xs font-medium uppercase text-gray-500">
                                    Categoria
                                </p>
                                <p
                                    class="mt-1 font-medium text-gray-900"
                                    x-text="producto.categoria"
                                ></p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button
                                type="button"
                                @click="open = false"
                                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                            >
                                Cerrar
                            </button>
                        </div>
                    </div>
                </template>
            </section>
        </div>
    </div>

    {{--Eliminar producto--}}
    @if ($idProducto !== null)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center
               bg-gray-900/60 p-4 ">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                <p class="mb-4">Confirmar eliminar producto</p>
                <button
                    type="button"
                    wire:click="eliminarProducto({{ $idProducto }})"
                    class="rounded-lg bg-red-600 px-4 py-1 text-sm font-medium text-white hover:bg-red-700"
                >
                    Eliminar
                </button>
                <button
                    type="button"
                    wire:click="$set('idProducto', null)"
                    class="rounded-lg border border-gray-300 px-4 py-1 text-sm"
                >
                    Cancelar
                </button>
            </div>
        </div>
    @endif
    {{--    Activar/Desactivar producto--}}
    @if ($idProductoStatus !== null)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center
               bg-gray-900/60 p-4 ">
            <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
                <p class="mb-4">Confirmar {{ $statusProducto }} producto</p>
                <button
                    type="button"
                    wire:click="cambiarStatusProducto({{ $idProductoStatus }})"
                    class="rounded-lg bg-red-600 px-4 py-1 text-sm font-medium text-white hover:bg-red-700"
                >
                    {{ $statusProducto }}
                </button>
                <button
                    type="button"
                    wire:click="$set('idProductoStatus', null)"
                    class="rounded-lg border border-gray-300 px-4 py-1 text-sm"
                >
                    Cancelar
                </button>
            </div>
        </div>
    @endif
</div>

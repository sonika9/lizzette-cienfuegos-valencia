<div class="container mx-auto max-w-7xl px-4 py-12">
    <header class="mb-4">
        @if ($tipoBloque === 'lista_productos')
            <h1 class="mt-2 text-3xl font-extrabold text-slate-900 sm:text-4xl mb-10">Catalogo de productos</h1>
        @elseif($tipoBloque === 'carrito')
            <h1 class="mt-2 text-3xl font-extrabold text-slate-900 sm:text-4xl mb-10">Carrito</h1>
        @endif
        <div class="flex justify-end">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    wire:click="$set('tipoBloque', 'carrito')">Ver Carrito ({{ array_sum($carritoProductos) }})
            </button>
        </div>
    </header>
    @if ($tipoBloque === 'lista_productos')
        <div class="mb-4 flex gap-2">
            <select
                wire:model.live.debounce.300ms="categoria"
                class="w-1/3 rounded-lg border border-gray-300 px-3 py-2">
                <option value="">Seleccione una categoria</option>
                <option value="alimentos_bebidas">Alimentos y Bebidas</option>
                <option value="deportes">Deportes</option>
                <option value="salud">Salud</option>
                <option value="ropa">Ropa</option>
            </select>
            <div class="w-1/3 items-center justify-center flex">
                <label class="mr-2">Solo disponibles</label>
                <input type="checkbox"
                       true-value="1"
                       false-value="0"
                       wire:model.live.debounce.300ms="disponibilidad"
                       class="rounded-sm border border-gray-300 px-2 py-2">
            </div>
            <select
                wire:model.live.debounce.300ms="precio"
                class="w-1/3 rounded-lg border border-gray-300 px-3 py-2">
                <option value="">Seleccione un rango de precios MXN</option>
                <option value="1"> < 100</option>
                <option value="2"> 100 a 500</option>
                <option value="3"> 500 a 1000</option>
                <option value="4"> > 1000</option>
            </select>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($productos as $producto)
                <div class="bg-white rounded-lg shadow-md p-4 flex flex-col h-full">
                    <div wire:click="$set('productoSeleccionadoId', {{ $producto->id }})" class="cursor-pointer">
                        @if ($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                                 class="w-full h-48 object-cover mb-4">
                        @else
                            <div class="w-full h-48 object-cover mb-4 bg-gray-200"></div>
                        @endif
                    </div>
                    <h2 class="text-xl font-bold mb-2">{{ Str::limit($producto->nombre, 40, '...') }}</h2>
                    <p class="text-gray-600">{{ Str::limit($producto->descripcion_corta, 100, '...') }}</p>
                    <p class="text-lg text-slate-900"><span class="font-bold">${{ $producto->precio_mxn }}</span> MXN
                        <span
                            class="text-sm text-gray-500">+ IVA</span></p>
                    <p class="text-lg text-slate-900"><span class="font-bold">${{ $producto->precio_usd }}</span> USD
                    </p>
                    <p class="mt-2 text-gray-600">
                        <span class="font-bold">SKU:</span>
                        {{ $producto->sku }}
                    </p>
                    <p class="text-gray-600">Stock: {{ $producto->stock }}</p>
                    <button wire:click="$set('productoSeleccionadoId', {{ $producto->id }})"
                            class="mt-2 text-blue-600 hover:text-blue-700">
                        Ver mas
                    </button>
                    @if (array_key_exists($producto->id, $carritoProductos) && $carritoProductos[$producto->id] > 0)
                        <div class="flex items-center">
                            <button
                                class="w-6 h-6 text-gray-500 hover:text-gray-700"
                                type="button"
                                wire:click="decrementarCantidadCarrito({{ $producto->id }})">
                                -
                            </button>
                            <input
                                type="number" min="1" step="1"
                                class="w-16 text-center appearance-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                wire:model.blur="carritoProductos.{{$producto->id}}"
                            >
                            <button
                                class="w-6 h-6 text-gray-500 hover:text-gray-700"
                                type="button"
                                wire:click="incrementarCantidadCarrito({{ $producto->id }})">
                                +
                            </button>
                            <i class="fas fa-trash ml-4 text-red-600"
                               wire:click="removerProductoDelCarrito({{ $producto->id }})"></i>
                        </div>
                    @else
                        <button
                            wire:click="incrementarCantidadCarrito({{ $producto->id }})"
                            class="mt-auto w-full inline-flex justify-center text-white bg-blue-600 box-border border border-transparent hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-xs font-medium leading-5 rounded-lg text-sm px-4 py-2.5 focus:outline-none">
                            Agregar al carrito
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $productos->links() }}
        </div>
    @elseif($tipoBloque == 'carrito')
        <div class="grid grid-cols-2 mt-20">
            <div class="grid grid-cols-1 mr-10">
                @foreach ($productosCarritoDetalle as $producto)
                    @if (array_key_exists($producto['id'], $carritoProductos) && $carritoProductos[$producto['id']] > 0)
                        <div class="bg-slate-50 block p-6 border border-slate-200 shadow-sm w-full mb-4">
                            <span class="font-bold">{{ $producto['nombre'] }}</span>
                            <p class="text-shadow-slate-600 mb-6">
                                {{ $producto['descripcion_corta'] }}
                            </p>
                            <p>
                                <span class="text-xl font-bold">${{ $producto['precio_mxn'] }} MXN</span>
                                <span class="text-xs text-slate-500"> + IVA</span>
                            </p>
                            <p>
                                <span class="text-xl font-bold">${{ $producto['precio_usd'] }} USD</span>
                            </p>
                            <div class="flex items-center">
                                <button
                                    class="w-6 h-6 text-gray-500 hover:text-gray-700"
                                    type="button"
                                    wire:click="decrementarCantidadCarrito({{ $producto['id'] }})">
                                    -
                                </button>
                                <input
                                    type="number" min="1" step="1"
                                    class="w-16 text-center appearance-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                    wire:model.blur="carritoProductos.{{$producto['id']}}"
                                >
                                <button
                                    class="w-6 h-6 text-gray-500 hover:text-gray-700"
                                    type="button"
                                    wire:click="incrementarCantidadCarrito({{ $producto['id'] }})">
                                    +
                                </button>
                                <i class="fas fa-trash ml-4 text-red-600"
                                   wire:click="removerProductoDelCarrito({{ $producto['id'] }})"></i>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if (count($productosCarritoDetalle) == 0)
                    <div class="">No hay productos en el carrito</div>
                @endif
            </div>
            <div>
                <div class="bg-slate-50 block p-6 border border-slate-200 shadow-sm w-full mt-11">
                    <p class="flex">
                        <span class="font-normal">Subtotal ({{ array_sum($carritoProductos) }} productos):</span><span
                            class="font-bold ml-2">${{ $subtotal }} MXN</span></p>
                    <p class="flex"><span
                            class="font-normal">Iva:</span><span
                            class="font-bold ml-2">${{ $iva }} MXN</span></p>
                    <p class="flex"><span
                            class="font-normal">Total ({{ array_sum($carritoProductos) }} productos):</span><span
                            class="font-bold ml-2">${{ $total }} MXN</span></p>
                    @if (array_sum($carritoProductos) > 0)
                        <div class="flex mt-2">
                            <span class="font-normal mr-2 mt-2">Email:</span>
                            <input type="email" wire:model.live.debounce.500ms="email" placeholder="Correo electrónico"
                                   class="w-1/2 border border-gray-300 rounded-md p-2 mb-4">
                        </div>
                        @if ($emailError)
                            <div class="text-red-500">El correo electrónico no es válido</div>
                        @endif
                    @endif
                    <button
                        @disabled(!filter_var($email, FILTER_VALIDATE_EMAIL) || $emailError)
                        wire:click="procesarPago"
                        wire:loading.attr="disabled"
                        class="mt-5 w-50 inline-flex justify-center text-black bg-green-300 box-border border border-transparent hover:bg-green-700 focus:ring-4 focus:ring-blue-300 shadow-xs font-medium leading-5 rounded-lg text-sm px-4 py-2.5 focus:outline-none
                            {{ $email && !$emailError ? 'text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 cursor-pointer' : 'text-gray-500 bg-gray-200 cursor-not-allowed opacity-60' }}">
                        <span wire:loading.remove wire:target="procesarPago">Proceder al pago</span>
                        <span wire:loading wire:target="procesarPago">Procesando...</span>
                    </button>
                </div>
            </div>
        </div>
    @elseif($tipoBloque == 'confirmacion')
        <div class="bg-slate-50 block p-6 border border-slate-200 shadow-sm w-full mt-5">
            <h5 class="mb-3 text-2xl font-semibold tracking-tight text-shadow-slate-900 leading-8">
                Su pago fue realizado con éxito!
            </h5>
            <p class="text-shadow-slate-600 mb-6">
                Se le enviara un correo con el detalle de su compra.
            </p>
            <a href="/"
                    class="ml-5 mt-5 w-40 inline-flex justify-center text-white bg-blue-600 box-border border border-transparent hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-xs font-medium leading-5 rounded-lg text-sm px-4 py-2.5 focus:outline-none">
                Continuar comprando
            </a>
        </div>
    @elseif($tipoBloque == 'detalle')
        <div class="grid grid-cols-1 mt-20">
            <h5 class="mb-3 text-2xl font-semibold tracking-tight text-shadow-slate-900 leading-8">
                {{ $productoSeleccionado->nombre }}
            </h5>
            <div class="bg-slate-50 block p-6 border border-slate-200 shadow-sm">
                @if ($productoSeleccionado->imagen)
                    <img src="{{ asset('storage/' . $productoSeleccionado->imagen) }}"
                         alt="{{ $productoSeleccionado->nombre }}"
                         class="w-[300px] h-[300px] object-cover mb-4">
                @else
                    <div class="w-[300px] h-[300px] object-cover mb-4 bg-gray-200"></div>
                @endif
                <p class="text-shadow-slate-600 mb-6">
                    {{ $productoSeleccionado->descripcion_larga }}
                </p>
                <p class="text-shadow-slate-600 mb-6">
                    <span class="font-bold">SKU:</span>
                    {{ $productoSeleccionado->sku }}
                </p>
                <p>
                    <span class="text-xl font-bold">${{ $productoSeleccionado->precio_mxn }} MXN</span>
                    <span class="text-xs text-slate-500"> + IVA</span>
                </p>
                <p>
                    <span class="text-xl font-bold">${{ $productoSeleccionado->precio_usd }} USD</span>
                </p>
                @if (array_key_exists($productoSeleccionado->id, $carritoProductos) && $carritoProductos[$productoSeleccionado->id] > 0)
                    <div class="flex items-center">
                        <button
                            class="w-6 h-6 text-gray-500 hover:text-gray-700"
                            type="button"
                            wire:click="decrementarCantidadCarrito({{ $productoSeleccionado->id }})">
                            -
                        </button>
                        <input
                            type="number" min="1" step="1"
                            class="w-16 text-center appearance-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                            wire:model.blur="carritoProductos.{{$productoSeleccionado->id}}"
                        >
                        <button
                            class="w-6 h-6 text-gray-500 hover:text-gray-700"
                            type="button"
                            wire:click="incrementarCantidadCarrito({{ $productoSeleccionado->id }})">
                            +
                        </button>
                        <i class="fas fa-trash ml-4 text-red-600"
                           wire:click="removerProductoDelCarrito({{ $productoSeleccionado->id }})"></i>
                    </div>
                @else
                    <button
                        wire:click="incrementarCantidadCarrito({{ $productoSeleccionado->id }})"
                        class="mt-auto w-1/3 inline-flex justify-center text-white bg-blue-600 box-border border border-transparent hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 shadow-xs font-medium leading-5 rounded-lg text-sm px-4 py-2.5 focus:outline-none">
                        Agregar al carrito
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>




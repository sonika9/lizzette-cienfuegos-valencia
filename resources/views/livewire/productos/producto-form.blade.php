<div>
    <label class="mb-1 block text-sm font-medium text-gray-700">
        Imagen
    </label>
    @if ($form->imagenPath)
        <img src="{{ asset('storage/' . $form->imagenPath) }}" alt="Imagen del producto" class="w-[200px] mb-2 rounded-lg border border-gray-300 px-3 py-2"/>
    @endif
    <input type="file" wire:model="form.imagen" accept="image/*" class="w-full rounded-lg border border-gray-300 px-3 py-2"/>
    @error('form.imagen')
    <p class="mt-1 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>
<div>
    <label class="mb-1 block text-sm font-medium text-gray-700">
        SKU
    </label>

    <input
        type="text"
        wire:model="form.sku"
        @disabled($form->sku !== null)
        class="w-full rounded-lg border border-gray-300 px-3 py-2 mb-2"
        placeholder="Introduzca SKU"
    >

    @error('form.sku')
    <p class="mt-1 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>
<div>
    <label class="mb-1 block text-sm font-medium text-gray-700">
        Nombre
    </label>

    <input
        type="text"
        wire:model="form.nombre"
        class="w-full rounded-lg border border-gray-300 px-3 py-2"
        placeholder="Introduzca nombre"
    >

    @error('form.nombre')
    <p class="mt-1 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>
<div>
    <label class="mb-1 block text-sm font-medium text-gray-700">
        Descripcion Corta
    </label>

    <input
        type="text"
        wire:model="form.descripcion_corta"
        class="w-full rounded-lg border border-gray-300 px-3 py-2"
        placeholder="Introduzca descripcion corta"
    >

    @error('form.descripcion_corta')
    <p class="mt-1 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>
<div>
    <label class="mb-1 block text-sm font-medium text-gray-700">
        Descripcion Larga
    </label>

    <textarea
        wire:model="form.descripcion_larga"
        class="w-full rounded-lg border border-gray-300 px-3 py-2"
        placeholder="Introduzca descripcion larga"
    ></textarea>

    @error('form.descripcion_larga')
    <p class="mt-1 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>
<div>
    <label class="mb-1 block text-sm font-medium text-gray-700">
        Precio USD
    </label>

    <input
        type="text"
        wire:model="form.precio_usd"
        class="w-full rounded-lg border border-gray-300 px-3 py-2"
        placeholder="Introduzca precio USD"
    >

    @error('form.precio_usd')
    <p class="mt-1 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>
<div>
    <label class="mb-1 block text-sm font-medium text-gray-700">
        Precio MXN
    </label>

    <input
        type="text"
        wire:model="form.precio_mxn"
        class="w-full rounded-lg border border-gray-300 px-3 py-2"
        placeholder="Introduzca precio MXN"
    >

    @error('form.precio_mxn')
    <p class="mt-1 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>
<div>
    <label class="mb-1 block text-sm font-medium text-gray-700">
        Stock
    </label>

    <input
        type="number"
        wire:model="form.stock"
        class="w-full rounded-lg border border-gray-300 px-3 py-2"
        placeholder="Introduzca stock"
    >

    @error('form.stock')
    <p class="mt-1 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>
<div>
    <label class="mb-1 block text-sm font-medium text-gray-700">
        Fecha de Vigencia
    </label>

    <input
        type="date"
        wire:model="form.fecha_vigencia"
        class="w-full rounded-lg border border-gray-300 px-3 py-2"
        placeholder="Introduzca fecha de vigencia"
    >

    @error('form.fecha_vigencia')
    <p class="mt-1 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>
<div>
    <label class="mb-1 block text-sm font-medium text-gray-700">
        Activo
    </label>

    <select
        wire:model="form.activo"
        class="w-full rounded-lg border border-gray-300 px-3 py-2">
        <option value="">Seleccione una opcion</option>
        <option value="1">Si</option>
        <option value="0">No</option>
    </select>

    @error('form.activo')
    <p class="mt-1 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-gray-700">
        Categoria
    </label>

    <select
        wire:model="form.categoria"
        class="w-full rounded-lg border border-gray-300 px-3 py-2">
        <option value="">Seleccione una categoria</option>
        <option value="alimentos_bebidas">Alimentos y Bebidas</option>
        <option value="deportes">Deportes</option>
        <option value="salud">Salud</option>
        <option value="ropa">Ropa</option>
    </select>

    @error('form.categoria')
    <p class="mt-1 text-sm text-red-600">
        {{ $message }}
    </p>
    @enderror
</div>

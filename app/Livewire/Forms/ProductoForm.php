<?php

namespace App\Livewire\Forms;

use App\Models\Producto;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Form;

class ProductoForm extends Form
{
    public ?int $id = null;
    public string $sku;
    public string $nombre;
    public string $descripcion_corta;
    public string $descripcion_larga;
    public float $precio_usd;
    public float $precio_mxn;
    public $imagen = null;
    public int $stock;
    public string $fecha_vigencia;
    public $activo;
    public string $categoria;
    public ?string $imagenPath = null;

    public function setProducto(Producto $producto)
    {
        $this->id = $producto->id;
        $this->sku = $producto->sku;
        $this->nombre = $producto->nombre;
        $this->descripcion_corta = $producto->descripcion_corta;
        $this->descripcion_larga = $producto->descripcion_larga;
        $this->precio_usd = $producto->precio_usd;
        $this->precio_mxn = $producto->precio_mxn;
        $this->stock = $producto->stock;
        $this->fecha_vigencia = $producto->fecha_vigencia ? \Carbon\Carbon::parse($producto->fecha_vigencia)->format('Y-m-d') : null;
        $this->activo = $producto->activo;
        $this->categoria = $producto->categoria;
        $this->imagenPath = $producto->imagen;
    }
    public function store()
    {
        Log::info('Creando producto form');
        $validated = $this->validate([
            'sku' => 'required|unique:productos,sku',
            'nombre' => 'required|string|max:250|regex:/^[a-zA-Z0-9\s]+$/',
            'descripcion_corta' => 'required',
            'descripcion_larga' => 'required',
            'precio_usd' => 'required|numeric|gt:0',
            'precio_mxn' => 'required|numeric|gt:0',
            'imagen' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'stock' => 'required|integer|gt:0',
            'fecha_vigencia' => 'required|date',
            'activo' => 'required|boolean',
            'categoria' => 'required|in:alimentos_bebidas,deportes,salud,ropa'
        ]);
        Log::info('Validación exitosa');
        if ($this->imagen) {
            $nombreImagen = 'producto_' . $this->sku . '.' . $this->imagen->extension();
            $validated['imagen'] = $this->imagen->storeAs('productos', $nombreImagen, 'public');
        }
        Log::info('Creando producto form');
        Producto::create($validated);
        Log::info('Producto creado con éxito');
    }

    public function update()
    {
        $validated = $this->validate([
            'nombre' => 'required|string|max:250|regex:/^[a-zA-Z0-9\s]+$/',
            'descripcion_corta' => 'required',
            'descripcion_larga' => 'required',
            'precio_usd' => 'required|numeric|gt:0',
            'precio_mxn' => 'required|numeric|gt:0',
            'imagen' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'stock' => 'required|integer|gt:0',
            'fecha_vigencia' => 'required|date',
            'activo' => 'required|boolean',
            'categoria' => 'required|in:alimentos_bebidas,deportes,salud,ropa'
        ]);
        $producto = Producto::find($this->id);
        if (!$producto)
        {
            return;
        }
        unset($validated['sku']);
        unset($validated['imagen']);
        if ($this->imagen) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $nombreImagen = 'producto_' . $this->sku . '.' . $this->imagen->extension();
            $validated['imagen'] = $this->imagen->storeAs('productos', $nombreImagen, 'public');
        }
        $producto->update($validated);
    }

    protected function messages() {
        return [
            'sku.required' => 'El SKU es requerido.',
            'sku.unique' => 'El SKU ya está en uso.',
            'nombre.required' => 'El nombre es requerido.',
            'nombre.regex' => 'El nombre solo puede contener letras, números y espacios.',
            'descripcion_corta.required' => 'La descripción corta es requerida.',
            'descripcion_larga.required' => 'La descripción larga es requerida.',
            'precio_usd.required' => 'El precio en USD es requerido.',
            'precio_mxn.required' => 'El precio en MXN es requerido.',
            'imagen.mimes' => 'La imagen debe ser un archivo JPG, JPEG, PNG o WEBP.',
            'imagen.max' => 'La imagen no debe exceder los 2MB.',
            'stock.required' => 'El stock es requerido.',
            'fecha_vigencia.required' => 'La fecha de vigencia es requerida.',
            'activo.required' => 'El campo activo es requerido.',
            'categoria.required' => 'La categoría es requerida.'
        ];
    }
}

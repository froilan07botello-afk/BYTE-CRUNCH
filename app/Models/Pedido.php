<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'user_id',
        'nombre_cliente',
        'telefono',
        'direccion',
        'referencia',
        'total',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }
    //agregamos la relacion "usuario"
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id');
    }


}

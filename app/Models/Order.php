<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'delivery_date', 'status'];

    #[Scope]
    protected function allowed(Builder $query)
    {
        $query->where('status', 'Allowed')->orderByDesc('created_at');
    }
}

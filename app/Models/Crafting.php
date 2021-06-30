<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crafting extends Model
{
    use HasFactory;

    protected $fillable = ['blueprint', 'input_items', 'output_item', 'amount', 'rush', 'time', 'price'];
}

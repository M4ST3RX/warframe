<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['user_id', 'item_id', 'amount'];

    public function item()
    {
        return $this->belongsTo(Item::class)->orderBy('name', 'ASC');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'item_id', 'type', 'periode', 'total', 'added_on'
    ];

	public function item()
    {
    	return $this->belongsTo(Item::class, 'item_id', 'id');
    }

}

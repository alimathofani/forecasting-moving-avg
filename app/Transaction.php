<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

class Transaction extends Model
{
    protected $fillable = [
        'template_id', 
        'type', 
        'periode', 
        'total'
    ];

	public function item()
    {
    	return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

}

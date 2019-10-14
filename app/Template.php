<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'name',
    ];

    public function settings() {
        return $this->belongsToMany(Setting::class,'templates_settings')->withPivot('value');
    }

    public function divider() {
        return $this->belongsToMany(Setting::class,'templates_settings')->where('name', 'forecasting-divider')->withPivot('value');
    }

    public function getSetDivAttribute()
    {
        return $this->divider->first()->pivot->value;
    }

    public function getCheckDivAttribute()
    {
        return $this->divider->wherePivot('status', 1);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class, 'template_id');
    }

    public function item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Warga extends Model
{
    //use SoftDeletes;

    protected $table = 'warga';

    public function keluarga()
    {
        return $this->hasMany(WargaKeluarga::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nama', 'like', '%'.$search.'%');
        })->when($filters['block'] ?? null, function ($query, $block) {
            $query->where('blok_rumah', 'LIKE',$block);
        });
    }
}

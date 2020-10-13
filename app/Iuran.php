<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Iuran extends Model
{
    protected $table = 'iuran';

    public function keluarga()
    {
        return $this->hasMany(WargaKeluarga::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nama', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}

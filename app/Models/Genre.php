<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $searchable = [
        'name'
    ];

    public function scopeSearch(Builder $query, string $search): void
    {
        if(!$search){
            return;
        }
        foreach($this->searchable as $column){
            $query = $query->where($column, 'LIKE', '%'.$search.'%');
        }
    }
}

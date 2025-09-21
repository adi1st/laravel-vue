<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['search'] ?? false, function ($q) use ($filters) {
                $searchTerm = '%' . $filters['search'] . '%';
                $q->where(function ($subQuery) use ($searchTerm) {
                    $subQuery->where('name', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm);
                });
            })->when($filters['order'] ?? false, function ($q) use ($filters) {
            if ($filters['order'] === 'latest') {
                $q->orderBy('created_at', 'desc');
            } elseif ($filters['order'] === 'oldest') {
                $q->orderBy('created_at', 'asc');
            }
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query)
    {
        return $query->when(request('search'), function ($query) {
            $query->where('title', 'LIKE', '%'.request('search').'%');
        })
            ->when(request()->has('is_published'), function ($query) {
                $query->where('is_published', request('is_published'));
            })
            ->when(request('sort_by'), function ($query) {
                $query->orderBy(request('sort_by'), request('order_by', 'asc'));
            });

    }
}

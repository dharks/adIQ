<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PluginRelease extends Model
{
    protected $fillable = [
        'version',
        'requires_wp',
        'requires_php',
        'tested_wp',
        'changelog',
        'zip_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * The latest active release — what the API serves.
     */
    public static function latest(): ?self
    {
        return static::where('is_active', true)
            ->orderByDesc('id')
            ->first();
    }
}

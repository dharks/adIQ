<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Site extends Model
{
    protected $fillable = [
        'user_id',
        'url',
        'license_key',
        'activated',
        'activated_url',
        'domain',
        'activated_at',
        'gam_connected',
        'gam_email',
        'gam_network_id',
        'gam_network_name',
        'suspended_at',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'activated'    => 'boolean',
            'gam_connected' => 'boolean',
            'activated_at' => 'datetime',
            'suspended_at' => 'datetime',
        ];
    }

    /* ── Relationships ─────────────────────────────────────────── */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gamToken(): HasOne
    {
        return $this->hasOne(GamToken::class);
    }

    public function allowedSubdomains(): HasMany
    {
        return $this->hasMany(SiteSubdomain::class)->orderBy('created_at');
    }

    /* ── Auto-generate license key ─────────────────────────────── */

    protected static function booted(): void
    {
        static::creating(function (Site $site) {
            if (empty($site->license_key)) {
                $site->license_key = strtolower(Str::random(32));
            }
        });
    }

    /* ── Scopes ────────────────────────────────────────────────── */

    public function scopeActivated($query)
    {
        return $query->where('activated', true);
    }

    public function scopeByLicenseKey($query, string $key)
    {
        return $query->where('license_key', strtolower($key));
    }

    public function scopeSuspended($query)
    {
        return $query->whereNotNull('suspended_at');
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('activated_at')->whereNull('suspended_at');
    }

    /* ── Suspension helpers ────────────────────────────────── */

    public function isSuspended(): bool
    {
        return !is_null($this->suspended_at);
    }
}

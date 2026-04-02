<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteSubdomain extends Model
{
    protected $fillable = ['site_id', 'subdomain'];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}

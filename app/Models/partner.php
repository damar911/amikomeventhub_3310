<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'deskripsi',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ─── Type Labels ──────────────────────────────────────────────────────────
    public static array $types = [
        'sponsor'   => 'Sponsor',
        'media'     => 'Media Partner',
        'community' => 'Community Partner',
        'other'     => 'Lainnya',
    ];

    public function getTypeLabelAttribute(): string
    {
        return self::$types[$this->type] ?? 'Lainnya';
    }

    // ─── Logo URL ─────────────────────────────────────────────────────────────
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    // ─── Auto Slug ────────────────────────────────────────────────────────────
    protected static function booted(): void
    {
        static::creating(function (Partner $partner) {
            if (empty($partner->slug)) {
                $partner->slug = Str::slug($partner->name);
            }
        });
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


}
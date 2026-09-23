<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'title', 'slug', 'description',
        'category_id', 'subcategory_id',
        'country_id', 'state_id', 'city_id', 'area_id',
        'price', 'currency', 'status', 'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
    ];

    /**
     * Boot method to auto-generate slug from title.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($listing) {
            if (empty($listing->slug)) {
                $listing->slug = Str::slug($listing->title) . '-' . Str::random(6);
            }
        });
    }

    /**
     * Get the user who created this listing.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the main category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the subcategory.
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    /**
     * Get the country.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'country_id');
    }

    /**
     * Get the state.
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'state_id');
    }

    /**
     * Get the city.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'city_id');
    }

    /**
     * Get the area.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'area_id');
    }

    /**
     * Get listing images.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class)->orderBy('sort_order');
    }

    /**
     * Get the primary image.
     */
    public function primaryImage()
    {
        return $this->hasOne(ListingImage::class)->where('is_primary', true);
    }

    /**
     * Scope to get only active listings.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get featured listings.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get formatted price with currency.
     */
    public function getFormattedPriceAttribute(): string
    {
        $symbols = ['INR' => '₹', 'USD' => '$', 'EUR' => '€', 'GBP' => '£'];
        $symbol = $symbols[$this->currency] ?? $this->currency . ' ';
        return $symbol . number_format($this->price, 0);
    }

    /**
     * Get the primary image URL or a placeholder.
     */
    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->images->where('is_primary', true)->first()
                   ?? $this->images->first();

        if ($primary) {
            return asset('storage/' . $primary->image_path);
        }

        return 'https://placehold.co/400x300/1f2937/f59e0b?text=' . urlencode(Str::limit($this->title, 15));
    }
}

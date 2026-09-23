<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('listings')
            ->orderBy('id')
            ->each(function (object $listing): void {
                $baseSlug = Str::slug($listing->title) ?: "listing-{$listing->id}";
                $slug = $baseSlug;
                $suffix = 2;

                while (DB::table('listings')
                    ->where('slug', $slug)
                    ->where('id', '!=', $listing->id)
                    ->exists()) {
                    $slug = "{$baseSlug}-{$listing->id}-{$suffix}";
                    $suffix++;
                }

                if ($listing->slug !== $slug) {
                    DB::table('listings')
                        ->where('id', $listing->id)
                        ->update(['slug' => $slug]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Existing slugs cannot be reliably reconstructed after normalization.
    }
};

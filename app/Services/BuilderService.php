<?php

namespace App\Services;

use App\Models\Builder;

class BuilderService
{
    public function generateUniqueSlug($slug, $ignoreId = null)
    {
        $original = $slug;
        $count = 1;

        while (
            Builder::where('slug', $slug)
            ->when($ignoreId, function ($q) use ($ignoreId) {
                $q->where('id', '!=', $ignoreId);
            })
            ->exists()
        ) {
            $slug = $original . '-' . $count;
            $count++;
        }

        return $slug;
    }
}

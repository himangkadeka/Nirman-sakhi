<?php

namespace App\Services;

use App\Models\Content;

class ContentService
{
    public function getDescriptionByTitle($title)
    {
        $content = Content::where('title', $title)->first();

        if ($content) {
            return $content->description;
        }

        return null;
    }
}

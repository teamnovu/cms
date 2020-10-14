<?php

namespace Statamic\Entries;

use Facades\Statamic\View\Cascade;
use Statamic\Contracts\Entries\LivePreview as LivePreviewContract;

class LivePreview implements LivePreviewContract
{
    public function toLivePreviewResponse($entry, $request, $extras)
    {
        Cascade::set('live_preview', $extras);

        return $entry->toResponse($request);
    }
}

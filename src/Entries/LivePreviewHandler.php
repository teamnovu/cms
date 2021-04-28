<?php

namespace Statamic\Entries;

use Facades\Statamic\View\Cascade;
use Illuminate\Support\Facades\Cache;
use Statamic\Auth\User as StatamicUser;
use Statamic\Contracts\Entries\LivePreviewHandler as LivePreviewContract;
use Statamic\Support\Str;

class LivePreviewHandler implements LivePreviewContract
{
    public function toLivePreviewResponse($entry, $request, $extras)
    {
        Cascade::set('live_preview', $extras);

        if (config('statamic.live_preview.external_url')) {
            $livePreviewCache = Cache::get('live-preview-data', []);

            if ($entry->id()) {
                $data = $entry->supplements();
            } else {
                $data = $entry->data();
            }

            $url = $entry->url();
            $currentLivePreviewUrl = Cache::get('current-live-preview-url', []);
            $userId = $this->getUserId();
            if (isset($currentLivePreviewUrl[$userId])) {
                $url = $currentLivePreviewUrl[$userId];
            } else {
                if (! $entry->id()) {
                    $url = '/'.Str::random(10);
                }

                $currentLivePreviewUrl[$userId] = $url;
                Cache::put('current-live-preview-url', $currentLivePreviewUrl);
            }

            $livePreviewCache[$userId][$url] = [
                'data' => $data,
                'collection' => $entry->collection()->handle(),
                'blueprint' => $entry->blueprint()->handle(),
                'slug' => $entry->slug(),
            ];

            Cache::put('live-preview-data', $livePreviewCache, now()->addMinutes(5));

            $livePreviewUrl = config('statamic.live_preview.external_url')."{$url}?preview={$userId}";

            return response([
                'data' => $livePreviewUrl,
            ]);
        }

        return $entry->toResponse($request);
    }

    protected function getUserId()
    {
        $user = auth()->user();

        if ($user instanceof StatamicUser) {
            return $user->id();
        }

        return $user->getKey();
    }
}

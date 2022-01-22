<?php

namespace Statamic\Query;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Statamic\Contracts\Entries\Entry;
use Statamic\Contracts\Entries\QueryBuilder;
use Statamic\Stache\Query\EntryQueryBuilder;
use Statamic\Support\Str;

class LivePreviewQueryBuilder extends EntryQueryBuilder implements QueryBuilder
{
    public function first()
    {
        $userId = request()->get('preview');

        if ($userId && $userId !== 'false') {
            $data = Cache::get("live-preview-data.{$userId}");

            if (!$data) {
                return null;
            }

            $entry = app(Entry::class)
                ->collection($data['collection'])
                ->blueprint($data['blueprint'])
                ->locale($this->wheres['site'] ?? 'default')
                ->published(true)
                ->id($data['data']['id'] ?: 'unsaved-'.Str::uuid())
                ->slug($data['slug'])
                ->date($data['data']['date'] ?? Carbon::now())
                ->data($data['data']);

            if (method_exists($entry, 'model')) {
                $entry->model(app(Entry::class));
            }

            return $entry;
        }

        return parent::first();
    }

    public function get($columns = ['*'])
    {
        return collect([$this->first()])->each->selectedQueryColumns($this->columns ?? $columns);
    }
}

<?php

namespace Statamic\GraphQL;

use Facades\Statamic\API\ResourceAuthorizer;
use Rebing\GraphQL\Support\Contracts\ConfigConvertible;
use Statamic\Facades\GraphQL;
use Statamic\GraphQL\Middleware\CacheResponse;
use Statamic\GraphQL\Queries\AssetContainerQuery;
use Statamic\GraphQL\Queries\AssetContainersQuery;
use Statamic\GraphQL\Queries\AssetQuery;
use Statamic\GraphQL\Queries\AssetsQuery;
use Statamic\GraphQL\Queries\CollectionQuery;
use Statamic\GraphQL\Queries\CollectionsQuery;
use Statamic\GraphQL\Queries\EntriesQuery;
use Statamic\GraphQL\Queries\EntryQuery;
use Statamic\GraphQL\Queries\FormQuery;
use Statamic\GraphQL\Queries\FormsQuery;
use Statamic\GraphQL\Queries\GlobalSetQuery;
use Statamic\GraphQL\Queries\GlobalSetsQuery;
use Statamic\GraphQL\Queries\NavQuery;
use Statamic\GraphQL\Queries\NavsQuery;
use Statamic\GraphQL\Queries\PingQuery;
use Statamic\GraphQL\Queries\SitesQuery;
use Statamic\GraphQL\Queries\TaxonomiesQuery;
use Statamic\GraphQL\Queries\TaxonomyQuery;
use Statamic\GraphQL\Queries\TermQuery;
use Statamic\GraphQL\Queries\TermsQuery;
use Statamic\GraphQL\Queries\UserQuery;
use Statamic\GraphQL\Queries\UsersQuery;

class DefaultSchema implements ConfigConvertible
{
    public function toConfig(): array
    {
        return $this->getConfig();
    }

    public static function config()
    {
        return app(self::class)->getConfig();
    }

    public function getConfig()
    {
        return [
            'types' => $this->getTypes(),
            'query' => $this->getQueries(),
            'mutation' => $this->getMutations(),
            'middleware' => $this->getMiddleware(),
            'method' => ['GET', 'POST'],
        ];
    }

    private function getTypes()
    {
        return config('statamic.graphql.types', []);
    }

    private function getQueries()
    {
        $queries = collect([PingQuery::class]);

        collect([
            'collections' => [CollectionsQuery::class, CollectionQuery::class, EntriesQuery::class, EntryQuery::class],
            'assets' => [AssetContainersQuery::class, AssetContainerQuery::class, AssetsQuery::class, AssetQuery::class],
            'taxonomies' => [TaxonomiesQuery::class, TaxonomyQuery::class, TermsQuery::class, TermQuery::class],
            'globals' => [GlobalSetsQuery::class, GlobalSetQuery::class],
            'navs' => [NavsQuery::class, NavQuery::class],
            'forms' => [FormsQuery::class, FormQuery::class],
            'sites' => [SitesQuery::class],
            'users' => [UsersQuery::class, UserQuery::class],
        ])->each(function ($qs, $resource) use (&$queries) {
            $queries = $queries->merge(ResourceAuthorizer::isAllowed('graphql', $resource) ? $qs : []);
        });

        return $queries
            ->merge(config('statamic.graphql.queries', []))
            ->merge(GraphQL::getExtraQueries())
            ->all();
    }

    private function getMutations()
    {
        return config('statamic.graphql.mutations', []);
    }

    private function getMiddleware()
    {
        return array_merge(
            [CacheResponse::class],
            config('statamic.graphql.middleware', []),
            GraphQL::getExtraMiddleware()
        );
    }
}

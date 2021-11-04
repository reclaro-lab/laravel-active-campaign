<?php

namespace ProjectRebel\ActiveCampaign\Controllers;

use Illuminate\Support\Arr;

trait Tags
{
    /**
     * Retrieve all existing tags.
     *
     * @param array|null $parameters
     * @return object|null
     */
    public function listTags(array $parameters = null): array
    {
        return $this->paginateTagsList();
    }

    protected function paginateTagsList(): array
    {
        $results = [];
        $limit = 20;
        $count = 0;
        $offset = 0;

        $dataRemaining = true;

        while ($dataRemaining) {
            $res = $this->send('GET', '/tags', ['limit' => $limit, 'offset' => $offset])->object();
            $count = count($res->tags);
            $offset = $count + $offset;
            $results[] = $res->tags;

            $dataRemaining = $count == $limit;
        }

        return Arr::flatten($results);
    }
}

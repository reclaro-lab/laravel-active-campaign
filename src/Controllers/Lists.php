<?php

namespace ProjectRebel\ActiveCampaign\Controllers;

use Illuminate\Support\Arr;

trait Lists
{
    /**
     * Retrieve all existing lists.
     *
     * @param array|null $parameters
     * @return object
     */
    public function listLists(array $parameters = null): array
    {
        return $this->paginateListsList();
    }

    protected function paginateListsList(): array
    {
        $results = [];
        $limit = 20;
        $count = 0;
        $offset = 0;

        $dataRemaining = true;

        while ($dataRemaining) {
            $res = $this->send('GET', '/lists', ['limit' => $limit, 'offset' => $offset])->object();
            $count = count($res->lists);
            $offset = $count + $offset;
            $results[] = $res->lists;

            $dataRemaining = $count == $limit;
        }

        return Arr::flatten($results);
    }
}

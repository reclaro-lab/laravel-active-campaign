<?php

namespace ProjectRebel\ActiveCampaign\Controllers;

use Illuminate\Support\Arr;

trait ContactTags
{

    /**
     * List all contact tag connections.
     *
     * @param integer $contactId
     * @return object
     */
    public function listContactTags(int $contactId): array
    {
        return $this->paginateContactTagsList($contactId);
    }

    /**
     * Add a tag to a contact.
     *
     * @param int $tagId
     * @param int $contactId
     * @return object
     */
    public function addTagToContact(int $tagId, int $contactId): object
    {
        $data = [
            "contactTag" => [
                "contact" => $contactId,
                "tag" => $tagId
            ]
        ];

        return $this->send('POST', '/contactTags', $data)->object();
    }

    /**
     * Remove a tag from a contact.
     *
     * @param int $contactTagId
     * @return object
     */
    public function removeTagFromContact(int $contactTagId): object
    {
        return $this->send('DELETE', '/contactTags/' . $contactTagId)->object();
    }

    protected function paginateContactTagsList(int $contactId): array
    {
        $results = [];
        $limit = 20;
        $count = 0;
        $offset = 0;

        $dataRemaining = true;

        while ($dataRemaining) {
            $res = $this->send('GET', '/contacts/' . $contactId . '/contactTags', ['limit' => $limit, 'offset' => $offset])->object();
            $count = count($res->contactTags);
            $offset = $count + $offset;
            $results[] = $res->contactTags;

            $dataRemaining = $count == $limit;
        }

        return Arr::flatten($results);
    }
}

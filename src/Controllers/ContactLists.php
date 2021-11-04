<?php

namespace ProjectRebel\ActiveCampaign\Controllers;

trait ContactLists
{

    /**
     * Subscribe a contact to a list.
     *
     * @param integer $listId
     * @param integer $contactId
     * @return object
     */
    public function addContactToList(int $listId, int $contactId): object
    {
        $data = [
            'contactList' => [
                'list' => $listId,
                'contact' => $contactId,
                'status' => 1
            ]
        ];

        return $this->send('POST', '/contactLists', $data)->object();
    }

    /**
     * Unsubscribe a contact from a list
     *
     * @param integer $listId
     * @param integer $contactId
     * @return object
     */
    public function removeContactFromList(int $listId, int $contactId): object
    {
        $data = [
            'contactList' => [
                'list' => $listId,
                'contact' => $contactId,
                'status' => 2
            ]
        ];

        return $this->send('POST', '/contactLists', $data)->object();
    }
}

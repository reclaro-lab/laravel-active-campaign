<?php

namespace ProjectRebel\ActiveCampaign\Controllers;

use Illuminate\Http\Client\Response;

trait Contacts
{
    /**
     * Create a new contact.
     *
     * @param array $data
     * @return Response
     */
    public function createContact(array $data): Response
    {
        return $this->send('POST', '/contacts', $data);
    }

    /**
     * Update an existing contact.
     *
     * @param integer $contactId
     * @param array $data
     * @return Response
     */
    public function updateContact(int $contactId, array $data): Response
    {
        return $this->send('PUT', '/contacts/' . $contactId, $data);
    }

    /**
     * Subscribe a contact to a list or unsubscribe a contact from a list.
     *
     * @param integer $contactId
     * @param array $data
     * @return Response
     */
    public function updateContactListStatus(int $contactId, array $data): Response
    {
        return $this->send('POST', '/contacts/' . $contactId . '/contactLists', $data);
    }

    /**
     * Retrieve an existing contact.
     *
     * @param integer $contactId
     * @return Response
     */
    public function retrieveContact(int $contactId): Response
    {
        return $this->send('GET', '/contacts/' . $contactId);
    }

    /**
     * Delete an existing contact
     *
     * @param integer $contactId
     * @return Response
     */
    public function deleteContact(int $contactId): Response
    {
        return $this->send('DELETE', '/contacts/' . $contactId);
    }

    /**
     * List all contacts, search contacts, or filter contacts by many criteria.
     *
     * @param array|null $parameters
     * @return Response
     */
    public function listContacts(array $parameters = null): Response
    {
        return $this->send('GET', '/contacts', $parameters);
    }
}

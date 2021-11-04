<?php

namespace ProjectRebel\ActiveCampaign\Controllers;

use Illuminate\Support\Facades\Log;

trait Contacts
{
    /**
     * Create a new contact.
     *
     * @param array $data
     * @return object
     */
    public function createContact(array $data): object
    {
        return $this->send('POST', '/contacts', $data)->object();
    }

    /**
     * Create or update contact
     *
     * @param array $data
     * @return object
     */
    public function syncContact(array $data): object
    {
        return $this->send('POST', '/contact/sync', $data)->object();
    }

    /**
     * Update an existing contact.
     *
     * @param integer $contactId
     * @param array $data
     * @return object
     */
    public function updateContact(int $contactId, array $data): object
    {
        return $this->send('PUT', '/contacts/' . $contactId, $data)->object();
    }

    /**
     * Subscribe a contact to a list or unsubscribe a contact from a list.
     *
     * @param integer $contactId
     * @param array $data
     * @return object
     */
    public function updateContactListStatus(int $contactId, array $data): object
    {
        return $this->send('POST', '/contacts/' . $contactId . '/contactLists', $data)->object();
    }

    /**
     * Retrieve an existing contact.
     *
     * @param integer $contactId
     * @return object
     */
    public function retrieveContact(int $contactId): object
    {
        return $this->send('GET', '/contacts/' . $contactId)->object();
    }

    /**
     * Delete an existing contact
     *
     * @param integer $contactId
     * @return object
     */
    public function deleteContact(int $contactId): object
    {
        return $this->send('DELETE', '/contacts/' . $contactId);
    }

    /**
     * List all contacts, search contacts, or filter contacts by many criteria.
     *
     * @param array|null $parameters
     * @return object
     */
    public function listContacts(array $parameters = null): object
    {
        return $this->send('GET', '/contacts', $parameters);
    }

    /**
     * Searches for a contact by an email address.
     *
     * @param string $email
     * @return object|null
     */
    public function retrieveContactByEmail(string $email): ?object
    {
        $results = $this->send('GET', '/contacts', ['email' => $email])->object();

        if (!isset($results->contacts)) {
            return null;
        }

        if (empty($results->contacts)) {
            return null;
        }

        return reset($results->contacts);
    }
}

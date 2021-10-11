<?php

namespace ProjectRebel\ActiveCampaign\Controllers;

use Illuminate\Http\Client\Response;

trait Accounts
{
    /**
     * Create a new account.
     *
     * @param array $data
     * @return Response
     */
    public function createAccount(array $data): Response
    {
        return $this->send('POST', '/accounts', $data);
    }

    /**
     * Update an existing account.
     *
     * @param integer $accountId
     * @param array $data
     * @return Response
     */
    public function updateAccount(int $accountId, array $data): Response
    {
        return $this->send('PUT', '/accounts/' . $accountId, $data);
    }

    /**
     * Retrieve an existing account.
     *
     * @param integer $accountId
     * @return Response
     */
    public function retrieveAccount(int $accountId)
    {
        return $this->send('GET', '/accounts/' . $accountId);
    }

    /**
     * Delete an existing account.
     *
     * @param integer $accountId
     * @return Response
     */
    public function deleteAccount(int $accountId): Response
    {
        return $this->send('DELETE', '/accounts/' . $accountId);
    }

    /**
     * Retrieve all existing accounts.
     *
     * @param array|null $parameters
     * @return Response
     */
    public function listAccounts(array $parameters = null): Response
    {
        return $this->send('GET', '/accounts', $parameters);
    }
}

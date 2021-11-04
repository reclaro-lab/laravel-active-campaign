<?php

namespace ProjectRebel\ActiveCampaign\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

trait Accounts
{
    /**
     * Create a new account.
     *
     * @param array $data
     * @return object
     */
    public function createAccount(array $data): object
    {
        return $this->send('POST', '/accounts', $data)->object();
    }

    /**
     * Update an existing account.
     *
     * @param integer $accountId
     * @param array $data
     * @return object
     */
    public function updateAccount(int $accountId, array $data): object
    {
        return $this->send('PUT', '/accounts/' . $accountId, $data)->object();
    }

    /**
     * Retrieve an existing account.
     *
     * @param integer $accountId
     * @return object
     */
    public function retrieveAccount(int $accountId): object
    {
        return $this->send('GET', '/accounts/' . $accountId)->object();
    }

    /**
     * Delete an existing account.
     *
     * @param integer $accountId
     * @return object
     */
    public function deleteAccount(int $accountId): object
    {
        return $this->send('DELETE', '/accounts/' . $accountId)->object();
    }

    /**
     * Retrieve all existing accounts.
     *
     * @param array|null $parameters
     * @return object
     */
    public function listAccounts(string $search = null): array
    {
        return $this->paginateAccountsList($search);
    }

    protected function paginateAccountsList(string $search = null): array
    {
        $results = [];
        $limit = 20;
        $count = 0;
        $offset = 0;

        $dataRemaining = true;

        while ($dataRemaining) {
            $params = [
                'limit' => $limit,
                'offset' => $offset
            ];

            if ($search) {
                $params['search'] = $search;
            }

            $res = $this->send('GET', '/accounts', $params)->object();
            $count = count($res->accounts);
            $offset = $count + $offset;
            $results[] = $res->accounts;

            $dataRemaining = $count == $limit;
        }

        return Arr::flatten($results);
    }
}

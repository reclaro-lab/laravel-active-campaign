<?php

namespace ProjectRebel\ActiveCampaign\Controllers;

use Illuminate\Support\Facades\Http;

trait Accounts
{
    public function createAccount($data)
    {
        return $this->send('POST', '/accounts', $data);
    }

    public function updateAccount($data) {
        return $this->send('PUT', '/accounts', $data);
    }

    public function retrieveAccount(int $accountId)
    {
        return $this->send('GET', '/accounts/' . $accountId);
    }

    public function deleteAccount(int $accountId)
    {
        return $this->send('DELETE', '/accounts/' . $accountId);
    }

    public function listAccounts(array $parameters = null)
    {
        return $this->send('GET', '/accounts', $parameters);
    }
}

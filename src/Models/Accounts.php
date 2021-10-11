<?php

namespace ProjectRebel\ActiveCampaign\Models;

use Illuminate\Support\Facades\Http;

trait Accounts
{
    public function createContact($data)
    {
        return $this->send('POST', '/contacts', $data);
    }

    public function retrieveAccount(int $accountId)
    {
        return $this->send('GET', '/accounts/' . $accountId);
    }

    // public function listContacts(array $parameters = null)
    // {
    //     return $this->send('GET', '/contacts', $parameters);
    // }
}

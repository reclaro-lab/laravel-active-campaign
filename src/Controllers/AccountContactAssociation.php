<?php

namespace ProjectRebel\ActiveCampaign\Controllers;

trait AccountContactAssociation
{

    /**
     * Create a new account association.
     *
     * @param integer $contactId
     * @param integer $accountId
     * @return object
     */
    public function createAccountContactAssociation(int $contactId, int $accountId): object
    {
        $data = [
            "accountContact" => [
                "contact" => $contactId,
                "account" => $accountId
            ]
        ];

        return $this->send('POST', '/accountContacts', $data)->object();
    }
}

<?php

namespace ProjectRebel\ActiveCampaign\Models;

use Illuminate\Support\Facades\Http;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class ActiveCampaign
{
    // use HasFactory;
    private $key;
    private $subdomain;
    private $url;

    public function __construct($key, $subdomain)
    {
        if (empty($key) || empty($subdomain)) {
            throw new \InvalidArgumentException;
        }

        $this->key = $key;
        $this->subdomain = $subdomain;
        $this->url = "https://{$subdomain}.api-us1.com/api/3";
    }

    public function send($method, $resource, $data = null)
    {
        $http = Http::withHeaders(['Api-Token' => $this->key]);

        switch ($method) {
            case 'GET':
                $response = $http->get($this->url . $resource, $data);
                break;
            case 'POST':
                $response = $http->post($this->url . $resource, $data);
                break;
            // case 'GET':
            //     echo "i equals 2";
            //     break;
        }

        return $response;
    }

    public function listContacts()
    {
        return $this->send('GET', '/contacts');
    }

    public function createContact($data)
    {
        return $this->send('POST', '/contacts', $data);
    }

    public function syncContact($data)
    {
        return $this->send('POST', '/contact/sync', $data);
    }

    public function addContactToList($contactId, $listId)
    {
        $data = [
            'contactList' => [
                'list' => $listId,
                'contact' => $contactId,
                'status' => 1
            ]
        ];

        return $this->send('POST', '/contactLists', $data);
    }

    public function unsubscribeContactFromList(int $contactId, int $listId)
    {
        $data = [
            'contactList' => [
                'list' => $listId,
                'contact' => $contactId,
                'status' => 2
            ]
        ];

        return $this->send('POST', '/contactLists', $data);
    }

    public function searchForTag(string $tag)
    {
        $data = [
            'search' => $tag
        ];

        return $this->send('GET', '/tags', $data);
    }

    public function addTagToContact(int $tagId, int $contactId)
    {
        $data = array(
            "contactTag" => array(
                "contact" => $contactId,
                "tag" => $tagId
            )
        );

        return $this->send('POST', '/contactTags', $data);
    }
}

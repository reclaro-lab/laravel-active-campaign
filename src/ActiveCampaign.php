<?php

namespace ProjectRebel\ActiveCampaign;

use Illuminate\Support\Facades\Http;


class ActiveCampaign
{
    use Controllers\Accounts;

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

    public function init()
    {
        return $this;
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
            case 'PUT':
                $response = $http->put($this->url . $resource, $data);
                break;
            case 'DELETE':
                $response = $http->delete($this->url . $resource, $data);
                break;
        }

        return $response;
    }

    public function listContacts(array $parameters = null)
    {
        return $this->send('GET', '/contacts', $parameters);
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

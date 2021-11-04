<?php

namespace ProjectRebel\ActiveCampaign;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ActiveCampaign
{
    use Controllers\Accounts;
    use Controllers\Contacts;
    use Controllers\ContactTags;
    use Controllers\AccountContactAssociation;
    use Controllers\ContactLists;
    use Controllers\Tags;
    use Controllers\Lists;

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

    /**
     * Send the request.
     *
     * @param string $method
     * @param string $resource
     * @param array|null $data
     * @return Response
     */
    public function send(string $method, string $resource, array $data = null): Response
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

    public function searchForTag(string $tag)
    {
        $data = [
            'search' => $tag
        ];

        return $this->send('GET', '/tags', $data);
    }
}

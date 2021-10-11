<?php

namespace ProjectRebel\ActiveCampaign\Classes;

class Account
{
    private int $id;
    public string $name;
    public string $accountUrl;
    private string $createdTimestamp;
    private string $updatedTimestamp;
    private array $links;
    public $fields;

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->accountUrl = $data['accountUrl'];
        $this->fields = $data['fields'];
    }
}

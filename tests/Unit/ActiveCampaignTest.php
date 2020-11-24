<?php

namespace ProjectRebel\ActiveCampaign\Tests\Unit;

use Illuminate\Support\Facades\Http;
use ProjectRebel\ActiveCampaign\Tests\TestCase;
use ProjectRebel\ActiveCampaign\Models\ActiveCampaign;
use ProjectRebel\ActiveCampaign\Facades\ActiveCampaign as ActiveCampaignFacade;

class ActiveCampaignTest extends TestCase
{
    public function testItCannotBeInstantiatedWithoutAuth()
    {
        $this->expectException(\ArgumentCountError::class);
        new ActiveCampaign();
    }

    public function testItCannotBeInstantiatedWithoutASubdomain()
    {
        $this->expectException(\ArgumentCountError::class);
        new ActiveCampaign('key');
    }

    public function testItCannotBeInstantiatedWithNulls()
    {
        $this->expectException(\InvalidArgumentException::class);
        new ActiveCampaign(null, null);
    }

    public function testItCannotBeInstantiatedWithEmptyStrings()
    {
        $this->expectException(\InvalidArgumentException::class);
        new ActiveCampaign('', '');
    }

    public function testItCanBeInstantiatedWithAKeyAndASubdomain()
    {
        $ac = new ActiveCampaign('key', 'subdomain');
        $this->assertInstanceOf(ActiveCampaign::class, $ac);
    }

    public function testItIncludesTheKeyInRequests()
    {
        Http::fake();
        $ac = new ActiveCampaign('key', 'subdomain');

        $ac->send('GET', '');

        Http::assertSent(function ($request) {
            return $request->hasHeader('Api-Token', 'key');
        });
    }

    public function testItUsesTheAccountInRequests()
    {
        Http::fake();
        $ac = new ActiveCampaign('key', 'subdomain');

        $ac->send('GET', '');

        Http::assertSent(function ($request) {
            return $request->url() == 'https://subdomain.api-us1.com/api/3';
        });
    }

    public function testItReturnsAResponseAfterSendingARequest()
    {
        $response = $this->ac->send('GET', '');

        $this->assertInstanceOf('Illuminate\Http\Client\Response', $response);
    }

    public function testItCanListContacts()
    {
        $expectedResponse = [
            'contacts' => [
                ['email' => 'janedoe@example.com', 'id' => '68'],
                ['email' => 'aaronallen@example.com', 'id' => '73']
            ]
        ];

        Http::fake([
            'https://subdomain.api-us1.com/api/3/contacts' => Http::response($expectedResponse, 200)
        ]);

        $response = $this->ac->listContacts();

        Http::assertSent(function ($request) {
            return $request->url() == 'https://subdomain.api-us1.com/api/3/contacts' && $request->method = 'GET';
        });

        $this->assertEquals($response->status(), 200);
        $this->assertEquals($expectedResponse, $response->json());
    }

    public function testItCanSearchForContactByEmail()
    {
        $expectedResponse = [
            'contacts' => [
                ['email' => 'janedoe@example.com', 'id' => '68'],
                ['email' => 'aaronallen@example.com', 'id' => '73']
            ]
        ];

        Http::fake([
            'https://subdomain.api-us1.com/api/3/contacts?email=janedoe%40example.com' => Http::response($expectedResponse, 200)
        ]);

        $response = $this->ac->listContacts(['email' => 'janedoe@example.com']);

        Http::assertSent(function ($request) {
            return $request->url() == 'https://subdomain.api-us1.com/api/3/contacts?email=janedoe%40example.com' && $request->method = 'GET';
        });

        $this->assertEquals($response->status(), 200);
        $this->assertEquals($expectedResponse, $response->json());
    }

    public function testItCanContactsWithAnArray()
    {
        $expectedResponse = [
            'contact' => [
                'email' => 'johndoe@example.com',
                'firstName' => 'John',
                'lastName' => 'Doe'
            ],
        ];

        Http::fake([
            'https://subdomain.api-us1.com/api/3/contacts' => Http::response($expectedResponse, 201)
        ]);

        $response = $this->ac->createContact([
            'contact' => [
                'email' => 'johndoe@example.com',
                'firstName' => 'John',
                'lastName' => 'Doe'
            ],
        ]);

        Http::assertSent(function ($request) {
            return $request->url() == 'https://subdomain.api-us1.com/api/3/contacts' && $request->method = 'POST';
        });

        $this->assertEquals($response->status(), 201);
        $this->assertEquals($expectedResponse, $response->json());
    }

    public function testItCanSyncContactsWithAnArray()
    {
        $expectedResponse = [
            'contact' => [
                'email' => 'johndoe@example.com',
                'firstName' => 'John',
                'lastName' => 'Doe'
            ],
        ];

        Http::fake([
            'https://subdomain.api-us1.com/api/3/contact/sync' => Http::response($expectedResponse, 201)
        ]);

        $response = $this->ac->syncContact([
            'contact' => [
                'email' => 'johndoe@example.com',
                'firstName' => 'John',
                'lastName' => 'Doe'
            ],
        ]);

        Http::assertSent(function ($request) {
            return $request->url() == 'https://subdomain.api-us1.com/api/3/contact/sync' && $request->method = 'POST';
        });

        $this->assertEquals($response->status(), 201);
        $this->assertEquals($expectedResponse, $response->json());
    }

    public function testItCanAddContactsToAList()
    {
        $expectedResponse = [
            'contact' => ['email' => 'johndoe@example.com'],
            'contactList' => [
                'list' => 2,
                'contact' => 1,
                'status' => 1
            ]
        ];

        Http::fake([
            'https://subdomain.api-us1.com/api/3/contactLists' => Http::response($expectedResponse, 200)
        ]);

        $response = $this->ac->addContactToList(1, 2);

        Http::assertSent(function ($request) {
            return $request->url() == 'https://subdomain.api-us1.com/api/3/contactLists' && $request->method = 'POST';
        });

        $this->assertEquals($response->status(), 200);
        $this->assertEquals($expectedResponse, $response->json());
    }

    public function testItCanUnsubscribeContactsFromAList()
    {
        $expectedResponse = [
            'contact' => ['email' => 'johndoe@example.com'],
            'contactList' => [
                'list' => 2,
                'contact' => 1,
                'status' => 0
            ]
        ];

        Http::fake([
            'https://subdomain.api-us1.com/api/3/contactLists' => Http::response($expectedResponse, 200)
        ]);

        $response = $this->ac->unsubscribeContactFromList(33093, 44);

        Http::assertSent(function ($request) {
            return $request->url() == 'https://subdomain.api-us1.com/api/3/contactLists' && $request->method = 'POST';
        });

        $this->assertEquals($response->status(), 200);
        $this->assertEquals($expectedResponse, $response->json());
    }

    public function testItCanSearchForTags()
    {
        $expectedResponse = array(
            "tag" => array(
                "tagType" => "contact",
                "tag" => "My Tag",
                "description" => "Description",
                "cdate" => "2018-10-04T14:55:13-05:00",
                "subscriber_count" => "0",
                "links" => array(
                    "contactGoalTags" => "https://subdomain.api-us1.com/api/3/tags/1/contactGoalTags"
                ),
                "id" => "1"
            )
        );

        Http::fake([
            'https://subdomain.api-us1.com/api/3/tags?search=some%20tag' => Http::response($expectedResponse, 200)
        ]);

        $response = $this->ac->searchForTag('some tag');

        Http::assertSent(function ($request) {
            return $request->url() == 'https://subdomain.api-us1.com/api/3/tags?search=some%20tag' && $request->method = 'GET';
        });

        $this->assertEquals($response->status(), 200);
        $this->assertEquals($expectedResponse, $response->json());
    }

    public function testItCanAddATagToAContact()
    {
        $expectedResponse = array(
            "contactTag" => array(
                "cdate" => "2017-06-08T16:11:53-05:00",
                "contact" => "1",
                "id" => "1",
                "links" => array(
                    "contact" => "/1/contact",
                    "tag" => "/1/tag"
                ),
                "tag" => "20"
            )
        );;

        Http::fake([
            'https://subdomain.api-us1.com/api/3/contactTags' => Http::response($expectedResponse, 201)
        ]);

        $response = $this->ac->addTagToContact(20, 1);

        Http::assertSent(function ($request) {
            return $request->url() == 'https://subdomain.api-us1.com/api/3/contactTags' && $request->method = 'POST';
        });

        $this->assertEquals($response->status(), 201);
        $this->assertEquals($expectedResponse, $response->json());
    }

    // public function testItCanRemoveATagFromAContact()
    // {
    // 
    // }

    public function testItWillReturnAnInstanceViaFacade()
    {
        config(['activecampaign.key' => 'key']);
        config(['activecampaign.subdomain' => 'subdomain']);
        $instance = ActiveCampaignFacade::init();
        $this->assertInstanceOf(ActiveCampaign::class, $instance);
    }

    public function testItCanBeUsedViaFacade()
    {
        $expectedResponse = [
            'contacts' => [
                ['email' => 'janedoe@example.com', 'id' => '68'],
                ['email' => 'aaronallen@example.com', 'id' => '73']
            ]
        ];

        Http::fake([
            'https://subdomain.api-us1.com/api/3/contacts' => Http::response($expectedResponse, 200)
        ]);

        config(['activecampaign.key' => 'key']);
        config(['activecampaign.subdomain' => 'subdomain']);

        $response = ActiveCampaignFacade::listContacts();

        Http::assertSent(function ($request) {
            return $request->url() == 'https://subdomain.api-us1.com/api/3/contacts' && $request->method = 'GET';
        });

        $this->assertEquals($response->status(), 200);
        $this->assertEquals($expectedResponse, $response->json());
    }
}

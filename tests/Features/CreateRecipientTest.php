<?php

namespace Test\Units;

use TestCase;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Domains\Recipients\Recipient;
use Symfony\Component\HttpFoundation\Response;

class CreateRecipientTest extends TestCase
{
    use DatabaseTransactions;

    public function testCanNoCreateRecipient()
    {
        $response = $this->post('/api/v1/recipients', []);

        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCanNoCreateDuplicatedRecipient()
    {
        $recipient = factory(Recipient::class)->create()->toArray();

        $response = $this->post('/api/v1/recipients', $recipient);

        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCanCreateRecipient()
    {
        $recipient = factory(Recipient::class)->make()->toArray();

        $response = $this->post('/api/v1/recipients', $recipient);

        $response
            ->receiveJson()
            ->seeStatusCode(Response::HTTP_CREATED)
            ->seeJsonContains([
                'name' => $recipient['name'],
                'email' => $recipient['email']
            ]);
    }
}

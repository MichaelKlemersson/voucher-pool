<?php

namespace Test\Units;

use TestCase;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Domains\Offers\Offer;
use Symfony\Component\HttpFoundation\Response;

class CreateOfferTest extends TestCase
{
    use DatabaseTransactions;

    public function testCanNoCreateOffer()
    {
        $response = $this->post('/api/v1/offers', []);

        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCanNoCreateDuplicatedOffer()
    {
        $offer = factory(Offer::class)->create();

        $response = $this->post('/api/v1/offers', [
            'name' => $offer->name,
            'discount' => 10
        ]);

        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCanNoCreateOfferWithHigherDiscount()
    {
        $offer = factory(Offer::class)->make(['discount' => 101])->toArray();

        $response = $this->post('/api/v1/offers', $offer);

        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCanNoCreateOfferWithNegativeDiscount()
    {
        $offer = factory(Offer::class)->make(['discount' => -1])->toArray();

        $response = $this->post('/api/v1/offers', $offer);

        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCanCreateOffer()
    {
        $offer = factory(Offer::class)->make()->toArray();
        $response = $this->post('/api/v1/offers', $offer);

        $response
            ->receiveJson()
            ->seeStatusCode(Response::HTTP_CREATED)
            ->seeJsonContains([
                'name' => $offer['name']
            ]);
    }
}

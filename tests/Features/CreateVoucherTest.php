<?php

namespace Test\Units;

use TestCase;
use App\Domains\Vouchers\Voucher;
use App\Domains\Offers\Offer;
use App\Domains\Recipients\Recipient;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CreateVoucherTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testCanNoCreateVouchers()
    {
        $response = $this->post('/api/v1/vouchers/generate');

        $response->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCanCreateVouchers()
    {
        $offer = factory(Offer::class)->create();
        $expirationDate = Carbon::now()->addDays(2);

        $response = $this->post('/api/v1/vouchers/generate', [
            'offer' => $offer->id,
            'end_date' => $expirationDate->format('Y-m-d H:i:s')
        ]);
        
        $response
            ->receiveJson()
            ->seeStatusCode(Response::HTTP_CREATED);
    }

    public function testCanNotListVouchersFromUnexistingRecipient()
    {
        $recipient = factory(Recipient::class)->make();

        $response = $this->get("/api/v1/vouchers/from-recipient", [
            'email' => $recipient->email
        ]);
        
        $response
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testListVouchersFromExistingRecipient()
    {
        $recipient = factory(Recipient::class)->create();
        $offer = factory(Offer::class)->create();
        $voucher = new Voucher([
            'offer_id' => $offer->id,
            'recipient_id' => $recipient->id,
            'end_date' => Carbon::now()->addDays(2)
        ]);
        $voucher->save();

        $response = $this->get("/api/v1/vouchers/from-recipient?" . http_build_query([
            'email' => $recipient->email
        ]));
        
        $response
            ->receiveJson()
            ->seeStatusCode(Response::HTTP_OK);
    }

    public function testCanNotGetDiscount()
    {
        $voucher = new Voucher([
            'end_date' => Carbon::now()->addDays(2)
        ]);

        $response = $this->get("/api/v1/vouchers/check?" . http_build_query([
            'code' => $voucher->code
        ]));
        
        $response
            ->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testGetDiscountForVoucher()
    {
        $recipient = factory(Recipient::class)->create();
        $offer = factory(Offer::class)->create();
        $voucher = new Voucher([
            'offer_id' => $offer->id,
            'recipient_id' => $recipient->id,
            'end_date' => Carbon::now()->addDays(2)
        ]);
        $voucher->save();

        $response = $this->get("/api/v1/vouchers/check?" . http_build_query([
            'code' => $voucher->code
        ]));
        
        $response
            ->receiveJson()
            ->seeJsonContains([
                'discount' => ($voucher->discount / 100.)
            ])
            ->seeStatusCode(Response::HTTP_OK);
    }
}

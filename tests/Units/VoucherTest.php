<?php

namespace Test\Units;

use TestCase;
use App\Domains\Vouchers\Voucher;
use App\Domains\Offers\Offer;
use App\Domains\Recipients\Recipient;
use App\Domains\Vouchers\Repositories\VoucherRepository;
use Carbon\Carbon;
use Mockery as m;

class VoucherTest extends TestCase
{
    public function testCreateWithDefaultCode()
    {
        $voucherCode = app()->make(Voucher::class)->code;

        $this->assertNotNull($voucherCode);
        $this->assertTrue(strlen($voucherCode) === 8);
    }

    public function testSetToken()
    {
        $voucherCode = app()->make(Voucher::class)->generateToken(20);
        $voucher = new Voucher([
            'code' => $voucherCode
        ]);

        $this->assertNotNull($voucherCode);
        $this->assertEquals($voucherCode, $voucher->code);
    }

    public function testIfVoucherIsValid()
    {
        $voucher = new Voucher([
            'end_date' => Carbon::now()->addDays(1)
        ]);

        $this->assertTrue($voucher->isValid());

        $voucher->used_date = Carbon::now();

        $this->assertFalse($voucher->isValid());

        $voucher->used_date = null;
        $voucher->end_date = $voucher->end_date->subDays(1);
        
        $this->assertFalse($voucher->isValid());
    }

    /**
     * @expectedException App\Domains\Vouchers\Exceptions\InvalidVoucherEndDateException
     */
    public function testCanNotGenerateVouchersWithInvalidDate()
    {
        $offer = factory(Offer::class)->make();
        $recipents = factory(Recipient::class, 10)->make();
        $endDate = Carbon::now()->subDays(1);
        $voucherRepository = app()->make(VoucherRepository::class);

        $vouchers = $voucherRepository->generateVouchers($offer, $recipents, $endDate);
    }

    public function testGenerateVouchers()
    {
        $offer = factory(Offer::class)->make();
        $recipents = factory(Recipient::class, 10)->make();
        $endDate = Carbon::now()->addDays(2);
        $voucherRepository = app()->make(VoucherRepository::class);

        $vouchers = $voucherRepository->generateVouchers($offer, $recipents, $endDate);

        $this->assertInternalType('array', $vouchers);
        $this->assertEquals($recipents->count(), count($vouchers));
    }
}

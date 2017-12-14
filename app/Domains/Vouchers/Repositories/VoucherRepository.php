<?php

namespace App\Domains\Vouchers\Repositories;

use App\Domains\Vouchers\Exceptions\InvalidVoucherEndDateException;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Domains\Vouchers\Voucher;
use App\Domains\Offers\Offer;
use Carbon\Carbon;

class VoucherRepository extends BaseRepository
{
    public function model()
    {
        return Voucher::class;
    }

    public function presenter()
    {
        return "Prettus\\Repository\\Presenter\\ModelFractalPresenter";
    }

    public function create(array $attributes)
    {
        if (!$this->isValidEndDate($attributes['end_date'])) {
            throw new InvalidVoucherEndDateException();
        }
        $attributes['offer_id'] = $attributes['offer'];

        return parent::create($attributes);
    }

    public function update(array $attributes, $id)
    {
        if (!$this->isValidEndDate($attributes['end_date'])) {
            throw new InvalidVoucherEndDateException();
        }
        $attributes['offer_id'] = $attributes['offer'];
        
        return parent::update($attributes, $id);
    }

    /**
     * Return an array of vouchers
     *
     * @param Offer $offer
     * @param array|Collection $recipents
     * @param string|DateTime $endDate
     * @throws InvalidVoucherEndDateException
     * @return array
     */
    public function generateVouchers(Offer $offer, $recipients, $endDate)
    {
        if (!$this->isValidEndDate($endDate)) {
            throw new InvalidVoucherEndDateException();
        }

        $vouchers = [];
        
        foreach ($recipients as $recipient) {
            $vouchers[] = new Voucher([
                'offer_id' => $offer->id,
                'recipient_id' => $recipient->id,
                'end_date' => is_string($endDate) ? Carbon::parse($endDate) : $endDate
            ]);
        }

        return $vouchers;
    }

    /**
     * Check if the date is greather then current date
     *
     * @param string $date
     * @return bool
     */
    protected function isValidEndDate($date)
    {
        $date = is_string($date) ? Carbon::parse($date) : $date;
        $now = Carbon::now();
        return $now->diffInHours($date, false) > 0;
    }

    /**
     * Return all valid voucher from a recipient
     *
     * @param string $email
     */
    public function getValidVouchersFrom(string $email)
    {
        return $this->skipPresenter(true)->with('offer')->whereHas('recipient', function ($subQuery) use ($email) {
            return $subQuery->where('email', $email);
        })->all()->filter(function ($voucher) {
            return $voucher->isValid();
        });
    }

    /**
     * Return the percentage of discount for the given voucher and set the voucher used date
     *
     * @param string $code
     * @return float
     */
    public function getDiscount(string $code)
    {
        $voucher = $this->skipPresenter()
            ->with('offer')
            ->findByField('code', $code)
            ->first();

        $voucher->used_date = Carbon::now();
        $voucher->save();

        return $voucher->offer->discount / 100.;
    }
}

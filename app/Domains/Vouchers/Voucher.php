<?php

namespace App\Domains\Vouchers;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\Traits\RandomToken;
use App\Domains\Recipients\Recipient;
use App\Domains\Offers\Offer;
use Carbon\Carbon;


class Voucher extends Model implements Transformable
{
    use RandomToken, SoftDeletes;

    protected $fillable = [
        'code',
        'recipient_id',
        'offer_id',
        'end_date',
        'used_date'
    ];

    protected $guarded = ['id'];

    protected $dates = [
        'used_date',
        'end_date'
    ];

    /**
     * Voucher Constructor
     * 
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        if (!isset($attributes['code'])) {
            $attributes['code'] = $this->generateToken();
        }
        parent::__construct($attributes);
    }

    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function transform()
    {
        return [
            'id' => (int) $this->id,
            'code' => (string) $this->code,
            'used_date' => $this->used_date ? $this->used_date->format('Y-m-d H:i:s') : '',
            'end_date' => $this->end_date ? $this->end_date->format('Y-m-d H:i:s') : '',
        ];
    }

    public function isValid()
    {
        if ($this->used_date == null) {
            return (Carbon::now())->diffInHours($this->end_date, false) > 0;
        }

        return false;
    }
}

<?php

namespace App\Domains\Offers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use App\Domains\Vouchers\Voucher;
use App\Domains\Recipients\Recipient;

class Offer extends Model implements Transformable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'discount',
        'slug'
    ];

    protected $guarded = ['id'];

    protected $hidden = ['slug'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

    public function recipients()
    {
        return $this->hasManyTrought(Voucher::class, Recipient::class);
    }

    public function transform()
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'discount' => (double) $this->discount,
        ];
    }
}

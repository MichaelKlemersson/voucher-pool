<?php

namespace App\Domains\Recipients;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domains\Vouchers\Voucher;

class Recipient extends Model implements Transformable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email'
    ];

    protected $guarded = ['id'];

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

    public function transform()
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}

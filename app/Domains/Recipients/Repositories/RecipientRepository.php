<?php

namespace App\Domains\Recipients\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Domains\Recipients\Recipient;

class RecipientRepository extends BaseRepository
{
    public function model()
    {
        return Recipient::class;
    }

    public function presenter()
    {
        return "Prettus\\Repository\\Presenter\\ModelFractalPresenter";
    }
}

<?php

namespace App\Domains\Offers\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Domains\Offers\Offer;
use App\Domains\Offers\Exceptions\DuplicatedOfferException;

class OfferRepository extends BaseRepository
{
    public function model()
    {
        return Offer::class;
    }

    public function presenter()
    {
        return "Prettus\\Repository\\Presenter\\ModelFractalPresenter";
    }

    public function create(array $attributes)
    {
        $this->checkIfOfferExists($attributes['name']);
        $this->skipPresenter(false);
        return parent::create($attributes);
    }

    public function update(array $attributes, $id)
    {
        $this->checkIfOfferExists($attributes['name']);
        $this->skipPresenter(false);
        return parent::update($attributes, $id);
    }

    protected function checkIfOfferExists(string $offerName)
    {
        $offer = $this->skipPresenter()->findByField('slug', str_slug($offerName))->first();
        if ($offer) {
            throw new DuplicatedOfferException();
        }
    }
}

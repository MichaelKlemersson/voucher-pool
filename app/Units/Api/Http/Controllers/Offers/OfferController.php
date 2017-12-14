<?php

namespace App\Units\Api\Http\Controllers\Offers;

use App\Core\Http\Controllers\Controller;
use App\Domains\Offers\Repositories\OfferRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Units\Api\Http\Validation\OfferValidation;
use Illuminate\Http\Request;
use App\Domains\Offers\Exceptions\DuplicatedOfferException;

class OfferController extends Controller
{
    private $offerRepository;

    public function __construct(OfferRepository $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    /**
     * @api {get} /offers
     * @apiName GetOffers
     * @apiGroup Offer
     * @apiVersion 0.1.0
     * 
     * @apiExample {curl} Example usage:
     *      curl -i http://localhost:8080/api/v1/offers
     */
    public function index()
    {
        return response()->json(
            $this->offerRepository->paginate(20)
        );
    }

    /**
     * @api {post} /offers
     * @apiName CreateOffer
     * @apiGroup Offer
     * @apiVersion 0.1.0
     * 
     * @apiParam {String} name offer name
     * @apiParam {Number} discount offer discount
     * 
     * @apiExample {curl} Example usage:
     *      curl -X POST -H 'Content-Type: application/json' -d '{"name":"first offer","discount":1.00}' http://localhost:8080/api/v1/offers
     */
    public function store(OfferValidation $validator, Request $request)
    {
        if ($validator->authorize()) {
            $this->validate($request, $validator->rules());
            try {        
                return response()->json(
                    $this->offerRepository->create($request->all()),
                    Response::HTTP_CREATED
                );
            } catch (DuplicatedOfferException $exception) {
                return response()->json($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
            } catch (\Exception $exception) {
                return response()->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return response()->json('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }
}

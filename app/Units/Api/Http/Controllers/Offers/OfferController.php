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

    public function index()
    {
        return response()->json(
            $this->offerRepository->paginate(20)
        );
    }

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

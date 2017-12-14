<?php

namespace App\Units\Api\Http\Controllers\Recipients;

use App\Core\Http\Controllers\Controller;
use App\Domains\Recipients\Repositories\RecipientRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Units\Api\Http\Validation\RecipientValidation;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    private $recipientRepository;

    public function __construct(RecipientRepository $recipientRepository)
    {
        $this->recipientRepository = $recipientRepository;
    }

    public function index()
    {
        return response()->json(
            $this->recipientRepository->paginate(20)
        );
    }

    public function store(RecipientValidation $validator, Request $request)
    {
        if ($validator->authorize()) {
            $this->validate($request, $validator->rules());

            return response()->json(
                $this->recipientRepository->create($request->all()),
                Response::HTTP_CREATED
            );
        }

        return response()->json('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }
}

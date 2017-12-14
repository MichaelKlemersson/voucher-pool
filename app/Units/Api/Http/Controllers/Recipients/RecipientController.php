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

    /**
     * @api {get} /recipients
     * @apiName GetRecipients
     * @apiGroup Recipient
     * @apiVersion 0.1.0
     *
     * @apiExample {curl} Example usage:
     *      curl -i http://localhost:8080/api/v1/recipients
     */
    public function index()
    {
        return response()->json(
            $this->recipientRepository->paginate(20)
        );
    }

    /**
     * @api {post} /recipients
     * @apiName CreateRecipient
     * @apiGroup Recipient
     * @apiVersion 0.1.0
     *
     * @apiParam {String} name recipient name
     * @apiParam {String} email recipient unique email
     *
     * @apiExample {curl} Example usage:
     *      curl -X POST -H 'Content-Type: application/json' -d '{"name":"foo bar","email":"foo@bar.baz"}' \
     * http://localhost:8080/api/v1/recipients
     */
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

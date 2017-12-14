<?php

namespace App\Units\Api\Http\Controllers\Vouchers;

use App\Domains\Vouchers\Exceptions\InvalidVoucherEndDateException;
use App\Core\Http\Controllers\Controller;
use App\Domains\Vouchers\Repositories\VoucherRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Units\Api\Http\Validation\VoucherValidation;
use App\Units\Api\Http\Validation\ListRecipientVoucherValidation;
use App\Units\Api\Http\Validation\GetVoucherDiscountValidation;
use Illuminate\Http\Request;
use App\Domains\Offers\Repositories\OfferRepository;
use App\Domains\Recipients\Repositories\RecipientRepository;

class VoucherController extends Controller
{
    private $voucherRepository;
    private $offerRepository;
    private $recipientRepository;

    public function __construct(
        VoucherRepository $voucherRepository,
        OfferRepository $offerRepository,
        RecipientRepository $recipientRepository
    )
    {
        $this->voucherRepository = $voucherRepository;
        $this->offerRepository = $offerRepository;
        $this->recipientRepository = $recipientRepository;
    }

    /**
     * @api {post} /vouchers/generate
     * @apiName CreateVouchers
     * @apiGroup Voucher
     * @apiVersion 0.1.0
     * 
     * @apiParam {Number} offer an offer id
     * @apiParam {String} end_date a final date for all vouchers using the format YYYY-MM-DD HH:ii:ss
     * 
     * @apiExample {curl} Example usage:
     *      curl -X POST -H 'Content-Type: application/json' -d '{"offer":"foo bar","end_date":"2018-01-01 23:59:59"}' http://localhost:8080/api/v1/vouchers/generate
     */
    public function generate(VoucherValidation $validator, Request $request)
    {
        if ($validator->authorize()) {
            $this->validate($request, $validator->rules());
            try {
                $vouchers = collect($this->voucherRepository->generateVouchers(
                    $this->offerRepository->skipPresenter()->find($request->input('offer')),
                    $this->recipientRepository->skipPresenter()->all(),
                    $request->input('end_date')
                ))->map(function ($voucher) {
                    $voucher->save();
                    return $voucher;
                });

                return response()->json($vouchers->toArray(), Response::HTTP_CREATED);
            } catch (InvalidVoucherEndDateException $exception) {
                return response()->json($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
            } catch (\Exception $exception) {
                abort(500);
            }
        }

        return response()->json('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @api {get} /vouchers/check
     * @apiName CheckVoucher
     * @apiGroup Voucher
     * @apiVersion 0.1.0
     * 
     * @apiParam {String} code the voucher code
     * 
     * @apiExample {curl} Example usage:
     *      curl -i http://localhost:8080/api/v1/vouchers/check?code=somecode
     */
    public function check(GetVoucherDiscountValidation $validator, Request $request)
    {
        if ($validator->authorize()) {
            $this->validate($request, $validator->rules($request->all()));

            return response()->json([
                'discount' => $this->voucherRepository->getDiscount($request->input('code'))
            ]);
        }

        return response()->json('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @api {get} /vouchers/from-recipient
     * @apiName ListRecipientVouchers
     * @apiGroup Voucher
     * @apiVersion 0.1.0
     * 
     * @apiParam {String} email an existing recipient email
     * 
     * @apiExample {curl} Example usage:
     *      curl -i http://localhost:8080/api/v1/vouchers/from-recipient?email=foo@bar.baz
     */
    public function getRecipientVouchers(ListRecipientVoucherValidation $validator, Request $request)
    {
        if ($validator->authorize()) {
            $this->validate($request, $validator->rules());

            return response()->json(
                $this->voucherRepository->getValidVouchersFrom($request->input('email'))
            );
        }

        return response()->json('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }
}

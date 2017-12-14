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

    public function check(GetVoucherDiscountValidation $validator, Request $request)
    {
        if ($validator->authorize()) {
            $this->validate($request, $validator->rules());

            return response()->json([
                'discount' => $this->voucherRepository->getVoucherDiscount($request->input('code'))
            ]);
        }

        return response()->json('Unauthorized', Response::HTTP_UNAUTHORIZED);
    }

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

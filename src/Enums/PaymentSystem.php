<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * Class PaymentSystem
 *
 * @SWG\Definition(
 *     definition="PaymentSystem",
 *     description="PaymentSystem model",
 *     @SWG\Property(
 *          property="value",
 *          type="integer",
 *          description="Payment system value",
 *          example=0
 *     ),
 *     @SWG\Property(
 *          property="description",
 *          type="string",
 *          description="Payment system description",
 *          example="Фонди"
 *     ),
 *     @SWG\Property(
 *          property="key",
 *          type="string",
 *          description="Payment system key",
 *          example="Fondy"
 *     )
 * )
 */
final class PaymentSystem extends Enum
{
    const Fondy = 0;
    const WayForPay = 1;
    const CloudPayments = 2;
}

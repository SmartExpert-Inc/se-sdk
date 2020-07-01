<?php

namespace SE\SDK\Enums;

use BenSampo\Enum\Enum;

final class PaymentSystem extends Enum
{
    const Fondy = 0;
    const WayForPay = 1;
    const CloudPayments = 2;
}

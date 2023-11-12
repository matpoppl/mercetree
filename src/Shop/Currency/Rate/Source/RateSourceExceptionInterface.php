<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Source;

interface RateSourceExceptionInterface extends \Throwable
{
    const CODE_ZERO = 1;
    const CODE_UNSUPPORTED_CURRENCY = 2;
    const CODE_DATE_NOT_FOUND = 3;
    const CODE_DATE_CURRENCY_NOT_FOUND = 4;
}

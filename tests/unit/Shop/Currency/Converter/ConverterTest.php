<?php

namespace Mateusz\Mercetree\Shop\Currency\Converter;

use Mateusz\Mercetree\Shop\Currency\CurrencyCode;
use Mateusz\Mercetree\Shop\Currency\Rate\RateProviderInterface;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    public function testConvert()
    {
        $rateValue = 2.0;
        $expectedCurrencyCode = 'FOO';
        $amount = 123.123;

        $rateProvider = self::createMock(RateProviderInterface::class);
        $rateProvider->method('getRate')
            ->willReturn($rateValue);

        $converter = new Converter($rateProvider, new CurrencyCode($expectedCurrencyCode));

        $result = $converter->convert($amount, $expectedCurrencyCode);

        self::assertEquals($rateValue * $amount, $result->getAmount());
        self::assertEquals($expectedCurrencyCode, $result->getCurrencyCode());
    }
}

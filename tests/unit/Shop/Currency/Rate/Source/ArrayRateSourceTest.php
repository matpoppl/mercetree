<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Source;

use PHPUnit\Framework\TestCase;

class ArrayRateSourceTest extends TestCase
{
    public function testUnsupportedCurrency()
    {
        self::expectException(RateSourceExceptionInterface::class);
        self::expectExceptionCode(RateSourceExceptionInterface::CODE_UNSUPPORTED_CURRENCY);
        $source = new ArrayRateSource('FOO', []);
        $source->getRate(new \DateTime(), 'BAR', 'BAZ');
    }

    public function testDateNotFound()
    {
        self::expectException(RateSourceExceptionInterface::class);
        self::expectExceptionCode(RateSourceExceptionInterface::CODE_DATE_NOT_FOUND);
        $source = new ArrayRateSource('FOO', []);
        $source->getRate(new \DateTime(), 'FOO', 'BAZ');
    }

    public function testCurrencyOnDateNotFound()
    {
        self::expectException(RateSourceExceptionInterface::class);
        self::expectExceptionCode(RateSourceExceptionInterface::CODE_DATE_CURRENCY_NOT_FOUND);

        $date = new \DateTime();

        $source = new ArrayRateSource('FOO', [
            $date->format('Y-m-d') => [],
        ]);
        $source->getRate($date, 'FOO', 'BAZ');
    }

    public function testGetRate()
    {
        $date = new \DateTime();

        $sourceCurrency = 'FOO';
        $targetCurrency = 'BAR';
        $expectedRate = 123.345;

        $source = new ArrayRateSource($sourceCurrency, [
            $date->format('Y-m-d') => [
                $targetCurrency => $expectedRate,
            ],
        ]);

        self::assertEquals($expectedRate, $source->getRate($date, $sourceCurrency, $targetCurrency));
        self::assertEquals(1.0 / $expectedRate, $source->getRate($date, $targetCurrency, $sourceCurrency));
    }

    public function testSourceMatchesTargetCurrency()
    {
        $date = new \DateTime();

        $sourceCurrency = 'FOO';

        $source = new ArrayRateSource($sourceCurrency, [
            $date->format('Y-m-d') => [],
        ]);

        self::assertEquals(1.0, $source->getRate($date, $sourceCurrency, $sourceCurrency));
    }
}

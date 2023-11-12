<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate;

use Mateusz\Mercetree\Shop\Currency\Rate\Source\ArrayRateSource;
use PHPUnit\Framework\TestCase;

class RateProviderTest extends TestCase
{
    public function testKnownSourceCurrency()
    {
        $today = new \DateTime();

        $sourceCurrency = 'SOURCE';
        $fooCurrency = 'FOO';
        $barCurrency = 'BAR';

        $fooRate = 2.3;
        $barRate = 4.3;

        $provider = new RateProvider($sourceCurrency, new ArrayRateSource($sourceCurrency, [
            $today->format('Y-m-d') => [
                $fooCurrency => $fooRate,
                $barCurrency => $barRate,
            ],
        ]));

        self::assertEquals(1.0, $provider->getRate($today, $sourceCurrency, $sourceCurrency));

        self::assertEquals($fooRate, $provider->getRate($today, $sourceCurrency, $fooCurrency));
        self::assertEquals($barRate, $provider->getRate($today, $sourceCurrency, $barCurrency));

        self::assertEquals( 1 / $fooRate, $provider->getRate($today, $fooCurrency, $sourceCurrency));
        self::assertEquals( 1 / $barRate, $provider->getRate($today, $barCurrency, $sourceCurrency));

        self::assertEquals( $fooRate / $barRate, $provider->getRate($today, $fooCurrency, $barCurrency));
        self::assertEquals( $barRate / $fooRate, $provider->getRate($today, $barCurrency, $fooCurrency));
    }
}

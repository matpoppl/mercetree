<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Data;

use Psr\SimpleCache\CacheInterface;
use DateTimeInterface;
use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;
use Psr\SimpleCache\InvalidArgumentException;

class Presenter implements PresenterInterface
{
    private DateTimeInterface $todayDate;

    /**
     *
     * @param RepositoryInterface $repository
     * @param CacheInterface $cache
     */
    public function __construct(private readonly RepositoryInterface $repository, private readonly CacheInterface $cache)
    {
        $this->todayDate = new \DateTime('today');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getRate(CurrencyCodeInterface $currency, DateTimeInterface $date = null) : float
    {
        $date ??= $this->todayDate;

        $currencyCode = $currency->getCurrencyCode();
        $dateString = $date->format('Ymd');

        $cacheKey = "{$currencyCode}-{$dateString}";

        $rate = $this->cache->get($cacheKey);

        if (null === $rate) {
            $rate = $this->repository->get($currency, $date);
            $this->cache->set($cacheKey, $rate);
        }

        if (null === $rate) {
            $rate = 1;
        }

        return $rate;
    }
}

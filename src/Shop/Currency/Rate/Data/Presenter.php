<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Data;

use Psr\SimpleCache\CacheInterface;
use DateTimeInterface;
use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;
use Psr\SimpleCache\InvalidArgumentException;

class Presenter
{
    private DateTimeInterface $todayDate;
    
    /**
     * 
     * @param RepositoryInterface $repository
     * @param CacheInterface $cache
     * @param boolean $throwExceptions
     */
    public function __construct(private RepositoryInterface $repository, private CacheInterface $cache, private $throwExceptions = true)
    {
        $this->todayDate = new \DateTime('today');
    }
    
    public function getRate(CurrencyCodeInterface $currency, DateTimeInterface $date = null) : float
    {
        $date ??= $this->todayDate;
        
        $rate = $this->getCachedRate($currency, $date);
        
        return (null === $rate) ? $this->repository->get($currency, $date) : $rate;
    }
    
    /**
     * 
     * @param CurrencyCodeInterface $currency
     * @param DateTimeInterface $date
     * @throws InvalidArgumentException
     * @return float|NULL
     */
    public function getCachedRate(CurrencyCodeInterface $currency, DateTimeInterface $date) : ?float
    {
        $currencyCode = $currency->getCurrencyCode();
        $dateString = $date->format('Ymd');
        
        $cacheKey = "{$currencyCode}-{$dateString}";
        
        try {
            return $this->cache->get($cacheKey);
        } catch (InvalidArgumentException $ex) {
            
            // @FIXME Illegal cache key format exception ?
            
            if ($this->throwExceptions) {
                throw $ex;
            }
        }
        
        return null;
    }
}

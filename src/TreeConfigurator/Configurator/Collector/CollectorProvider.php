<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\Collector;

use Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeRepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeDecorationRepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Feature\EntityFeatureFactoryInterface;

class CollectorProvider implements CollectorProviderInterface
{
    public function __construct(
        private readonly TreeRepositoryInterface $treeRepository,
        private readonly TreeDecorationRepositoryInterface $decorationRepository,
        private readonly EntityFeatureFactoryInterface $entityFeatureFactory)
    {
    }

    public function get(string $baseProductId) : FeatureCollectorInterface
    {
        $baseProduct = $this->treeRepository->getById($baseProductId);

        if (! $baseProduct) {
            throw ProductException::productNotFound($baseProductId);
        }

        return new ProductCollector($this->decorationRepository, $this->entityFeatureFactory, $baseProduct);
    }
}

<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\Collector;

use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureInterface;
use Mateusz\Mercetree\Shop\Product\View\ProductInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\Product;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeEntity;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeDecorationRepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Feature\EntityFeatureFactoryInterface;

class ProductCollector implements ProductCollectorInterface, FeatureCollectorInterface
{
    private readonly ProductInterface $baseProduct;

    /**
     * @var ProductInterface[]
     */
    private array $decorations = [];

    public function __construct(
        private readonly TreeDecorationRepositoryInterface $decorationRepository,
        private readonly EntityFeatureFactoryInterface $featureFactory,
        TreeEntity $tree
    ) {
        $this->baseProduct = new Product($tree, 1);
    }

    public function getFeature(string $featureId) : FeatureInterface
    {
        $entity = $this->decorationRepository->getById($featureId);

        if (! $entity) {
            throw ProductException::featureNotFound($featureId);
        }

        $this->decorations[] = new Product($entity, 1);

        return $this->featureFactory->create($entity);
    }

    public function getBaseProduct() : ProductInterface
    {
        return $this->baseProduct;
    }

    /**
     * @return ProductInterface[]
     */
    public function getDecorations(): array
    {
        return $this->decorations;
    }
}

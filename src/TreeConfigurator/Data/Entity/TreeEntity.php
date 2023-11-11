<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Entity;

/**
 * @see \Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeRepository
 */
class TreeEntity extends AbstractProduct implements ProductInterface
{
    private string $size;

    public function getId() : string
    {
        return "tree:{$this->getSize()}";
    }

    public function getName() : string
    {
        return $this->getId();
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    public function toStorageRecord() : array
    {
        return [
            'size' => $this->getSize(),
        ] + parent::toStorageRecord();
    }

    public function fromStorageRecord(array $record) : void
    {
        $this->setSize($record['size']);
        parent::fromStorageRecord($record);
    }
}

<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Entity;

/**
 * @see \Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeRepository
 */
class TreeEntity extends AbstractProduct implements ProductInterface
{
    private string $size;
    private array $rows;

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

    public function getRows(): array
    {
        return $this->rows;
    }

    public function setRows(array $rows): void
    {
        $this->rows = $rows;
    }

    public function toStorageRecord() : array
    {
        return [
            'size' => $this->getSize(),
            'rows' => implode(',', $this->getRows()),
        ] + parent::toStorageRecord();
    }

    public function fromStorageRecord(array $record) : void
    {
        $this->setSize($record['size']);
        $this->setRows(explode(',', $record['rows']));
        parent::fromStorageRecord($record);
    }
}

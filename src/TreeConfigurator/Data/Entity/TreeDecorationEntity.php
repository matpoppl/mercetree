<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Entity;

class TreeDecorationEntity extends AbstractProduct implements ProductInterface
{
    private string $size;
    private string $coating;
    private string $model;

    public function getId() : string
    {
        return "model:{$this->getModel()}/size:{$this->getSize()}/coating({$this->getCoating()})";
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

    public function getCoating(): string
    {
        return $this->coating;
    }

    public function setCoating(string $coating): void
    {
        $this->coating = $coating;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function toStorageRecord() : array
    {
        return [
                'size' => $this->getSize(),
                'coating' => $this->getCoating(),
                'model' => $this->getModel(),
            ] + parent::toStorageRecord();
    }

    public function fromStorageRecord(array $record) : void
    {
        $this->setSize($record['size']);
        $this->setCoating($record['coating']);
        $this->setModel($record['model']);
        parent::fromStorageRecord($record);
    }
}

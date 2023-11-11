<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Entity;

class ConstraintEntity implements ProductConstraintInterface
{
    protected string $productId;
    protected ?string $slotName;
    protected string $constraintType;

    /**
     * @var array<string, mixed>
     */
    protected array $constraintArgs;

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }

    public function getSlotName(): ?string
    {
        return $this->slotName;
    }

    public function setSlotName(?string $slotName): void
    {
        $this->slotName = $slotName;
    }

    public function getConstraintType(): string
    {
        return $this->constraintType;
    }

    public function setConstraintType(string $constraintType): void
    {
        $this->constraintType = $constraintType;
    }

    public function getConstraintArgs(): array
    {
        return $this->constraintArgs;
    }

    public function setConstraintArgs(array $constraintArgs): void
    {
        $this->constraintArgs = $constraintArgs;
    }

    public function toStorageRecord() : array
    {
        return [
            'product_id' => $this->getProductId(),
            'slot_name' => $this->getSlotName(),
            'constraint_type' => $this->getConstraintType(),
            'constraint_args' => $this->getConstraintArgs(),
        ];
    }

    public function fromStorageRecord(array $record) : void
    {
        $this->setProductId($record['product_id']);
        $this->setSlotName($record['slot_name'] ?? null);
        $this->setConstraintType($record['constraint_type']);
        $this->setConstraintArgs($record['constraint_args'] ?? []);
    }
}

<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

enum TransactionStatusEnum
{
    case BEGIN;
    case COMMIT;
    case ROLLBACK;
}

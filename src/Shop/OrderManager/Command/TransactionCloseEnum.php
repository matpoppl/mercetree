<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Command;

enum TransactionCloseEnum
{
    case COMMIT;
    case ROLLBACK;
}

<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

enum RepositoryCloseEnum
{
    case COMMIT;
    case ROLLBACK;
}

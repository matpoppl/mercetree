<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Event;

enum CreateOrderStepEnum
{
    case BEGIN;
    case COMMIT;
    case ROLLBACK;
}

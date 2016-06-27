<?php

namespace Plp\Task;

class Account extends AbstractTask
{
    public static function bill($data)
    {
        throw new FatalException('Fatal exception error');
    }
}
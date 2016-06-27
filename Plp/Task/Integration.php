<?php

namespace Plp\Task;

class Integration extends AbstractTask
{
    public static function process($data)
    {
        throw new UserException('User exception error');
    }
}
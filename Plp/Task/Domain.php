<?php

namespace Plp\Task;

class Domain extends AbstractTask
{
    public static function addzone($data)
    {
        return ['zone' => $data['domain']];
    }
}
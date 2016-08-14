<?php

namespace Koopa\Bundle\AppBundle\Assembler;

abstract class AbstractAssembler
{
    public static function setPageTitle($title, $action = 'create')
    {
        switch ($action) {
            case 'show':
                return $title;
                break;
            case 'edit':
                return 'edit the ' . $title;
                break;
            default:
                return 'create a new ' . $title;
                break;
        }
    }
}

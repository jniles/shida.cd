<?php

namespace Koopa\Bundle\AppBundle\Tests\Assembler;

use Koopa\Bundle\AppBundle\Assembler\AbstractAssembler;

class AbstractAssemblerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getTitles
     */
    public function testSetPageTitle($title, $action, $expected)
    {
        $assembler = new BaseAssembler();

        $this->assertEquals(
            $expected,
            $assembler->setPageTitle($title, $action)
        );
    }

    public function getTitles()
    {
        return array(
            array('savon', 'create', 'create a new savon'),
            array('savon', 'show', 'savon'),
            array('savon', 'edit', 'edit the savon'),
        );
    }
}

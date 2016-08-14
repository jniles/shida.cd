<?php

namespace Koopa\Bundle\JobBundle\Tests\Assembler;

use Koopa\Bundle\JobBundle\Assembler\ViewSkillAssembler;
use Koopa\Bundle\JobBundle\Entity\Skill;

class ViewSkillAssemblerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $skill     = (new Skill())->setName('Skill of the test');
        $assembler = new ViewSkillAssembler();

        $vm = $assembler->create($skill);

        $this->assertEquals(
            'Skill of the test',
            $vm->name
        );
    }
}

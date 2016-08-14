<?php

namespace Koopa\Bundle\JobBundle\Tests\Assembler;

use Koopa\Bundle\JobBundle\Assembler\ViewJobAssembler;
use Koopa\Bundle\JobBundle\ViewModel\ViewJob;

class ViewJobAssemblerTest extends \PHPUnit_Framework_TestCase
{
    protected static $jobs;

    public static function setupBeforeClass()
    {
        $data = [];

        $job = new ViewJob();
        $job->id = 1;
        $job->createdAt = new \DateTime("20-05-2015");

        $data[] = $job;

        for ($i=2; $i <= 3; $i++) {
            $job = new ViewJob();
            $job->id = $i;
            $job->createdAt = new \DateTime("0$i-06-2015");

            $data[] = $job;
        }

        self::$jobs = $data;
    }


    public function testGroupByMonth()
    {
        $viewJobAssembler = new ViewJobAssembler();
        $actual = $viewJobAssembler->groupByMonth(self::$jobs);

        $this->assertInternalType('array', $actual);
        $this->assertEquals(2, count($actual));
        $this->assertEquals(
            '20-05-2015',
            $actual['05-2015'][0]->createdAt->format('d-m-Y')
        );
    }
}

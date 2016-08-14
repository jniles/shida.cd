<?php

namespace Koopa\Bundle\AppBundle\Tests\Util;

use Koopa\Bundle\AppBundle\Util\HtmlModify;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HtmlModifyTest extends WebTestCase
{
    public function testModify()
    {
        $response = new Response('<html>Some string</html>');
        $htmlModifiy = new HtmlModify();

        $response = $htmlModifiy->modify($response);

        $this->assertInstanceOf(
            'Symfony\Component\HttpFoundation\Response',
            $response
        );
    }
}

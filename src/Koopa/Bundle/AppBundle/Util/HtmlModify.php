<?php

namespace Koopa\Bundle\AppBundle\Util;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DomCrawler\Crawler;

class HtmlModify
{
    public function modify(Response $response)
    {
        // $crawler = new Crawler();
        // $crawler->addContent($response->getContent());



        // $itemActive = $crawler->filter('.c-sidebar__menu__item-container a.is-active');
        // dump($itemActive);
        // die();

        return $response;
    }
}

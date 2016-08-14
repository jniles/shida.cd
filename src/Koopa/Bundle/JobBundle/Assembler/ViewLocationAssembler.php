<?php

namespace Koopa\Bundle\JobBundle\Assembler;

use Koopa\Bundle\AppBundle\Assembler\AbstractAssembler;

use Koopa\Bundle\JobBundle\ViewModel\ViewLocation;
use Koopa\Bundle\JobBundle\Entity\Location;

class ViewLocationAssembler extends AbstractAssembler
{
    public function create(Location $location, $action = 'create', $leftJoin = false)
    {

        $vm          = new ViewLocation();
        $vm->id      = $location->getId();
        $vm->country = $location->getCountry();
        $vm->town    = $location->getTown();
        $vm->slug    = $location->getSlug();

        if ('show' === $action || 'edit' === $action) {
            $vm->pageTitle = $this->setPageTitle(
                $location->getTown(),
                $action
            );
        } else {
            $vm->pageTitle = $this->setPageTitle('location');
        }

        return $vm;
    }

    public function createList(array $locations)
    {
        $vm            = new ViewLocation();
        $vm->pageTitle = 'lists of location';

        foreach ($locations as $location) {
            $vLocation          = new ViewLocation();
            $vLocation->id      = $location->getId();
            $vLocation->country = $location->getCountry();
            $vLocation->town    = $location->getTown();
            $vLocation->slug    = $location->getSlug();

            $vm->collections[] = $vLocation;
        }

        return $vm;
    }
}

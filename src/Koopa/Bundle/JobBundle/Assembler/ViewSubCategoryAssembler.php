<?php

namespace Koopa\Bundle\JobBundle\Assembler;

use Koopa\Bundle\AppBundle\Assembler\AbstractAssembler;

use Koopa\Bundle\JobBundle\ViewModel\ViewSubCategory;
use Koopa\Bundle\JobBundle\Entity\SubCategory;

class ViewSubCategoryAssembler extends AbstractAssembler
{
    public function create(SubCategory $subCategory, $action = 'create', $leftJoin = false)
    {

        $vm       = new ViewSubCategory();
        $vm->id   = $subCategory->getId();
        $vm->name = $subCategory->getName();
        $vm->slug = $subCategory->getSlug();

        if ('show' === $action || 'edit' === $action) {
            $vm->pageTitle = $this->setPageTitle(
                $subCategory->getName(),
                $action
            );
        } else {
            $vm->pageTitle = $this->setPageTitle('Subcategory');
        }

        return $vm;
    }

    public function createList(array $subCategories)
    {
        $vm            = new ViewSubCategory();
        $vm->pageTitle = 'lists of categories';

        foreach ($subCategories as $cat) {
            $vCategory          = new ViewSubCategory();
            $vCategory->id      = $cat->getId();
            $vCategory->name    = $cat->getName();
            $vCategory->slug    = $cat->getSlug();

            $vm->collections[] = $vCategory;
        }

        return $vm;
    }
}

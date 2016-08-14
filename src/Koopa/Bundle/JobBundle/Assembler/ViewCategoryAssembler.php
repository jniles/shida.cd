<?php

namespace Koopa\Bundle\JobBundle\Assembler;

use Koopa\Bundle\AppBundle\Assembler\AbstractAssembler;

use Koopa\Bundle\JobBundle\ViewModel\ViewCategory;
use Koopa\Bundle\JobBundle\Entity\Category;

class ViewCategoryAssembler extends AbstractAssembler
{
    public function create(Category $category, $action = 'create', $leftJoin = false)
    {

        $vm       = new ViewCategory();
        $vm->id   = $category->getId();
        $vm->name = $category->getName();
        $vm->slug = $category->getSlug();

        if ('show' === $action || 'edit' === $action) {
            $vm->pageTitle = $this->setPageTitle(
                $category->getName(),
                $action
            );
        } else {
            $vm->pageTitle = $this->setPageTitle('category');
        }

        return $vm;
    }

    public function createList(array $categories)
    {
        $vm            = new ViewCategory();
        $vm->pageTitle = 'lists of categories';

        foreach ($categories as $cat) {
            $vCategory          = new ViewCategory();
            $vCategory->id      = $cat->getId();
            $vCategory->name    = $cat->getName();
            $vCategory->slug    = $cat->getSlug();

            $vm->collections[] = $vCategory;
        }

        return $vm;
    }
}

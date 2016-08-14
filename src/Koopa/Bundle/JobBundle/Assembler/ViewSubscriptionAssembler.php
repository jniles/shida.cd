<?php
namespace Koopa\Bundle\JobBundle\Assembler;

use Koopa\Bundle\AppBundle\Assembler\AbstractAssembler;
use Koopa\Bundle\JobBundle\Entity\Subscription;
use Koopa\Bundle\JobBundle\ViewModel\ViewSubscription;
use Koopa\Bundle\UserBundle\Assembler\ViewUserAssembler;

class ViewSubscriptionAssembler extends AbstractAssembler
{
    /**
     * @var ViewUserAssembler
     */
    protected $viewUserAssembler;

    /**
     * @param ViewUserAssembler $viewUserAssembler
     */
    public function __construct(ViewUserAssembler $viewUserAssembler)
    {
        $this->viewUserAssembler = $viewUserAssembler;
    }

    /**
     * @param Subscription $subscription
     * @param string $action
     * @param bool $leftJoin
     * @return ViewSubscription
     */
    public function create(Subscription $subscription, $action = 'show', $leftJoin = false)
    {
        $vm = new ViewSubscription();
        $vm->id = $subscription->getId();
        $vm->accept = $subscription->getAccept();
        $vm->createdAt = $subscription->getCreatedAt();
        $vm->user = $this->viewUserAssembler->create($subscription->getUser());

        return $vm;
    }

    public function createList(array $subscriptions, $leftJoin = false)
    {
        $vm = new ViewSubscription();

        foreach($subscriptions as $subscription) {
            $vm->collections[] = $this->create($subscription);
        }

        return $vm;
    }
}

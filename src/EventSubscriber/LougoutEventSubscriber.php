<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LougoutEventSubscriber implements EventSubscriberInterface
{
    public function onLogoutEvent(LogoutEvent $event)
    {
        $event->getRequest()->getSession()->getFlashBag()->add('success', 'Vous êtes déconnecté.');
    }

    public static function getSubscribedEvents()
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}

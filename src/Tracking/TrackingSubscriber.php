<?php

declare(strict_types=1);

namespace App\Tracking;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TrackingSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onRequest',
        ];
    }

    public function onRequest(RequestEvent $event): void
    {
        $trackingId = $event->getRequest()->query->get('trackingId');

        if ($trackingId !== null) {
            $event->getRequest()->getSession()->replace(['trackingId' => $trackingId]);
        }
    }
}

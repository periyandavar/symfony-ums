<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ViewSubscriber implements EventSubscriberInterface
{

    private $logger;

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['nonResponseCaught']
        ];
    }

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function nonResponseCaught(ViewEvent $viewEvent)
    {
        $ctrl = $viewEvent->getRequest()->attributes->get("_controller");
        $this->logger->debug("A non Response object is returned from the action ");
    }
}

<?php

namespace App\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Psr\Log\LoggerInterface;

class DatabaseActivitySubscriber implements EventSubscriber
{

    private $log;

    public function __construct(LoggerInterface $log)
    {
        $this->log = $log;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate
        ];
    }

    public function addToLog($msg)
    {
        $this->log->info($msg);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $object = get_class($args->getObject());
        $this->addToLog("New instance created : " . $object);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $object = get_class($args->getObject());
        $this->addToLog("Instance removed : " . $object);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $object = get_class($args->getObject());
        $this->addToLog("New instance updated : " . $object);
    }
}

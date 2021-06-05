<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class ViewListener
{
    public function onKernelView(ViewEvent $viewEvent)
    {
        $value = $viewEvent->getControllerResult();
        $value = "<html><body>" . $value . "</body></html>";
        $viewEvent->setResponse(new Response($value));
        dump($viewEvent);
    }
}

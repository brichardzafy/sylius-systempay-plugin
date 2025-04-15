<?php

declare(strict_types=1);

namespace Sylius\SystempayPlugin\EventListener;

use Sylius\Resource\Symfony\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class SystempayOnDisplayForm
{
    
    public function __invoke(GenericEvent $event): void
    {
        dump($event);
    }

    public function onOrderComplete(RequestEvent $event): void{
        //$event->setResponse(new Response('Hello World!'));
        dump($event);die();
    }
}
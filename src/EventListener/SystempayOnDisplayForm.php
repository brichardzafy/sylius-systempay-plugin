<?php

declare(strict_types=1);

namespace Sylius\SystempayPlugin\EventListener;

use Sylius\Resource\Symfony\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Twig\Environment;
class SystempayOnDisplayForm
{

    public function __construct(private Environment $twig)
    {
        $this->twig = $twig;
    }

    public function onInitializeOrderComplete(GenericEvent $event): void
    {
        $response = $event->getResponse();
        
    }
    public function onOrderComplete(ViewEvent $event): void{
        //$event->setResponse(new Response('Hello World!'));
        dump($event);die();
    }

    public function onOrderCompleteController(ControllerEvent $event): void
    {
       
        if ($event->getRequest()->attributes->get('_route') === 'sylius_shop_checkout_complete') {
            $this->twig->addGlobal('logoLogin', '<a href="https://www.systempay.fr/" target="_blank"><img src="https://www.systempay.fr/wp-content/uploads/2020/01/logo-systempay.png" alt="Systempay" /></a>');

        }
        // Do something with the request, like modifying headers or parameters
        // $request->headers->set('X-Custom-Header', 'value');
    }
}
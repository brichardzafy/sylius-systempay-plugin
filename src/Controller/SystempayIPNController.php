<?php

declare(strict_types=1);

namespace Sylius\SystempayPlugin\Controller;

use App\Entity\Payment\PaymentMethod;
use App\Service\OrderService;
use Doctrine\ORM\EntityManagerInterface;
use Gaufrette\FilesystemInterface;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\InvoicingPlugin\Doctrine\ORM\InvoiceRepositoryInterface;
use Sylius\InvoicingPlugin\Generator\InvoiceFileNameGeneratorInterface;
use Sylius\InvoicingPlugin\Generator\TwigToPdfGeneratorInterface;
use Sylius\InvoicingPlugin\Manager\InvoiceFileManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;


class SystempayIPNController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }
    
    public function ipnAction(Request $request): Response
    {
        $kr_answer = $request->get('kr_answer',"[]");
        $kr_answer = json_decode($kr_answer, true);
        dump($kr_answer);
        if(!empty($kr_answer)){
            $systemPayMethod = $this->entityManager->getRepository(PaymentMethod::class)->findOneBy([
                "code" => "systempay",
            ]);
            if ($systemPayMethod instanceof PaymentMethod) {
                $configuration =  $systemPayMethod->getGatewayConfig()->getConfig();
            }else {
                throw new \RuntimeException('Systempay payment method not found.');
            }
            return new Response('ok');
        }
       return new Response('KO');
    }
}
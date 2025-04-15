<?php

declare(strict_types=1);

namespace Sylius\SystempayPlugin\Controller;

use App\Entity\Payment\PaymentMethod;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\SystempayPlugin\Entity\SystempayIpn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @author Brichard <brichard.zafy@gmail.com>
 * SystempayIPNController
 */
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

        if(!empty($kr_answer)){
            $systemPayMethod = $this->entityManager->getRepository(PaymentMethod::class)->findOneBy([
                "code" => "systempay",
            ]);
            if ($systemPayMethod instanceof PaymentMethod) {
                $configuration =  $systemPayMethod->getGatewayConfig()->getConfig();
                $dateTime = date_create(str_replace(" 00:00", "", $kr_answer['serverDate']));
                $systempayIpn = new SystempayIpn();
                $systempayIpn->setOrderStatus($kr_answer['orderStatus'])
                             ->setShopId($kr_answer['shopId'])
                             ->setOrderCycle($kr_answer['orderCycle'])
                             ->setServerDate($dateTime)
                             ->setOrderDetails($kr_answer['orderDetails'])
                             ->setCustomer($kr_answer['customer'])
                             ->setTransactions($kr_answer['transactions']);
                $this->entityManager->persist($systempayIpn);
                $this->entityManager->flush();
            }else {
                throw new \RuntimeException('Systempay payment method not found.');
            }
            return new Response('ok');
        }
       return new Response('KO');
    }
}
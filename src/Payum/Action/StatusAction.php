<?php
declare(strict_types=1);

namespace Sylius\SystempayPlugin\Payum\Action;


use Lyra\Client;
use Lyra\Exceptions\LyraException;
use Payum\Core\Action\ActionInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\GetStatusInterface;
use Sylius\Component\Core\Model\PaymentInterface as SyliusPaymentInterface;
use Sylius\SystempayPlugin\Payum\SyliusApi;
final class StatusAction implements ActionInterface
{
    /** @var \Sylius\SystempayPlugin\Payum\SyliusApi */
    private $api;
    /** @var  Client */
    private $client;

    /**
     * StatusAction constructor.
     * @param SyliusApi $api
     * @param Client $client
     */
    public function __construct(SyliusApi $api, Client $client)
    {
        $this->api = $api;
        $this->client=$client;

    }

    /**
     * @throws LyraException
     */
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        /** @var SyliusPaymentInterface $payment */
        $payment = $request->getFirstModel();

        $details = $payment->getDetails();
        $this->client->setUsername($this->api->getUserId());
        $this->client->setPassword($this->api->getPassword());
        $this->client->setPublicKey($this->api->getPublicKey());
        $this->client->setSHA256Key($this->api->getSHA256Key());
        $this->client->setEndpoint('https://api.systempay.fr');
       
        if(!$this->client->checkHash($this->client->getSHA256Key())){
            $request->markCanceled();
            throw new LyraException("Invalid Hash FRAUD SPOTTED");
        }
        $paymentResponse= json_decode($_POST['kr-answer']);
        $payment->setDetails((array) $paymentResponse);
//        $request->getModel()->setStorage((array) $paymentResponse);
        $statusPayment= $paymentResponse->orderStatus;
      //  dump($request,$statusPayment);die();
        
        switch ($statusPayment) {
            case "PAID" : // transaction approuvée ou traitée avec succès
                $request->markCaptured();
                break;
            case "RUNNING" : // contacter l’émetteur de carte
                $request->markPending();
                break;
            case "UNPAID" : // Annulation client.
                $request->markCanceled();
            break;
        }

    }

    public function supports($request): bool
    {
        return
            $request instanceof GetStatusInterface &&
            $request->getFirstModel() instanceof SyliusPaymentInterface;
    }


}
<?php
declare(strict_types=1);

namespace Sylius\SystempayPlugin\Payum\Action;


use Lyra\Client;
use GuzzleHttp\Exception\RequestException;
use Payum\Core\Action\ActionInterface;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Core\Reply\HttpRedirect;
use Psr\Log\LoggerInterface;
use Sylius\Component\Core\Model\PaymentInterface as SyliusPaymentInterface;
use Sylius\SystempayPlugin\Payum\Request\CaptureRequest;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Sylius\SystempayPlugin\Payum\SyliusApi;

final class CaptureAction implements ActionInterface, ApiAwareInterface
{
    /** @var Client */
    public $client;
    /** @var \Sylius\SystempayPlugin\Payum\SyliusApi */
    private $api;
   /** @var Environment */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->client = new Client();
        $this->twig = $twig;
    }

    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);
        /** @var SyliusPaymentInterface $payment */
        $payment = $request->getModel();
        $customerEmail=$payment->getOrder()->getCustomer()->getEmail();
        $orderId= $payment->getOrder()->getId();
//        testpublickey_mETb5YxL8BWUi0f4ITfqQH4tbzkA0kSTA6Ypy2P1ejsSm
        $this->client->setUsername($this->api->getUserId());
        $this->client->setPassword($this->api->getPassword());
        $this->client->setPublicKey($this->api->getPublicKey());
        $this->client->setSHA256Key($this->api->getSHA256Key());
        $this->client->setEndpoint('https://api.systempay.fr');

        $store = array("amount" => $payment->getAmount(),
            "currency" => $payment->getCurrencyCode(),
            "orderId" => $orderId,
            "customer" => array(
                "email" => $customerEmail
            ));

        $response = $this->client->post("V4/Charge/CreatePayment", $store);
 
        /* I check if there are some errors */
        if ($response['status'] != 'SUCCESS') {
            /* an error occurs, I throw an exception */
            $error = $response['answer'];
            throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage'] );
        }

        /* everything is fine, I extract the formToken */


        $formToken = $response["answer"]["formToken"];
        $payment->setDetails(['status' => 200 ]);
        $request->setDataForm([
                'formToken'=> $formToken,
                'publicKey'=> $this->client->getPublicKey(),
                'clientEndpoint'=>$this->client->getClientEndpoint(),
                'lyraClient'=>$this->client,
        ]);
    }

    public function supports($request): bool
    {
        return
            $request instanceof CaptureRequest &&
            $request->getModel() instanceof SyliusPaymentInterface;
    }

    public function setApi($api): void
    {
        if (!$api instanceof SyliusApi) {
            throw new UnsupportedApiException('Not supported. Expected an instance of ' . SyliusApi::class);
        }

        $this->api = $api;
    }
}
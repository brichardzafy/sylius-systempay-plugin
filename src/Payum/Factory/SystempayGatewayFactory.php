<?php

declare(strict_types=1);

namespace Sylius\SystempayPlugin\Payum\Factory;

use Lyra\Client;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;
use Sylius\SystempayPlugin\Payum\Action\StatusAction;
use Sylius\SystempayPlugin\Payum\SyliusApi;
final class SystempayGatewayFactory extends GatewayFactory
{
    protected function populateConfig(ArrayObject $config): void
    {
        $syliusApi = new SyliusApi(
            $config['public_key'], 
            strval($config['user']), 
        $config["mode"] == SyliusApi::MODE_DEV ? $config['public_test_key'] : $config['public_key'],
        $config["mode"] == SyliusApi::MODE_DEV ? $config['hmac_sha_256_test'] :  $config['hmac_sha_256_test'],
        $config["mode"] == SyliusApi::MODE_DEV ? $config['test_password'] :  $config['prod_password'],
        );
        $config->defaults([
            'payum.factory_name' => 'systempay',
            'payum.factory_title' => 'Systempay',
            'payum.action.status' => new StatusAction($syliusApi,new Client()),
        ]);
        $config['payum.api'] = function (ArrayObject $config) use ($syliusApi) {
            return $syliusApi;
        };
    }
}
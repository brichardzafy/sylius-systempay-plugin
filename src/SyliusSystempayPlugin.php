<?php

declare(strict_types=1);

namespace Sylius\SystempayPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SyliusSystempayPlugin extends Bundle
{
    use SyliusPluginTrait;



    public function getPath(): string
    {
        return \dirname(__FILE__);
    }


}

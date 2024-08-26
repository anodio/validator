<?php

namespace Anodio\Validator\ServiceProviders;
use Anodio\Core\AttributeInterfaces\ServiceProviderInterface;
use Anodio\Core\Attributes\ServiceProvider;

#[ServiceProvider]
class ValidatorServiceProvider implements ServiceProviderInterface
{
    public function register(\DI\ContainerBuilder $containerBuilder): void
    {

    }
}

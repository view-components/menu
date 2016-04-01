<?php

namespace ViewComponents\Menu;

use Interop\Container\ContainerInterface;
use ViewComponents\ViewComponents\Rendering\TemplateFinder;
use ViewComponents\ViewComponents\Service\ServiceContainer;
use ViewComponents\ViewComponents\Service\ServiceId;
use ViewComponents\ViewComponents\Service\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(ServiceContainer $container)
    {
        /** registers path to menu views */
        $container->extend(ServiceId::TEMPLATE_FINDER, function (TemplateFinder $finder) {
            $finder->registerPath(dirname(__DIR__) . '/resources/views');
            return $finder;
        });

        $container->set(MenuServiceId::CONTAINER_FACTORY, function (ContainerInterface $container) {
            return function () {
                return new MenuContainer();
            };
        });

        $container->set(MenuServiceId::ITEM_FACTORY, function (ContainerInterface $container) {
            return new MenuItemFactory();
        });
    }
}

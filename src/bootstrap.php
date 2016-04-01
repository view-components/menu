<?php
namespace ViewComponents\ViewComponents\Grids;

use ViewComponents\Menu\Menu;
use ViewComponents\Menu\MenuFacade;
use ViewComponents\Menu\ServiceProvider;
use ViewComponents\ViewComponents\Service\Bootstrap;

Bootstrap::registerServiceProvider(ServiceProvider::class);

class_alias(MenuFacade::class, 'ViewComponents\Menu');
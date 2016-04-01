<?php

namespace ViewComponents\Menu\Test;

use PHPUnit_Framework_TestCase;
use ViewComponents\Menu;
use ViewComponents\Menu\MenuContainer;
use ViewComponents\Menu\MenuItem;
use ViewComponents\ViewComponents\Base\ContainerComponentInterface;
use ViewComponents\ViewComponents\Storage\ComponentStorage;
use ViewComponents\ViewComponents\Storage\FileStorage;


class Test extends PHPUnit_Framework_TestCase
{

    public function testSerializeAndRestore()
    {
        Menu::main()
            ->addChild(new MenuItem('/home', 'Home'))
            ->makeItem('/help', 'Help');
        Menu::useStorage($storage = new ComponentStorage(new FileStorage(PROJECT_DIR . '/storage')));
        Menu::save(Menu::MAIN_MENU);

        /** @var MenuContainer $menu */
        $menu = $storage->get('menu_' . Menu::MAIN_MENU);
        $out = $menu->render();
        self::assertTrue(strpos($out, '/home') !== false);
        self::assertTrue(strpos($out, '/help') !== false);
    }

    public function testCreate()
    {
        self::assertTrue(Menu::get('footer') instanceof ContainerComponentInterface);
    }
}
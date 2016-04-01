<?php

namespace ViewComponents\Menu;

class MenuItemFactory
{
    public function __invoke()
    {
        return new MenuItem();
    }
}

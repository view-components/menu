<?php

namespace ViewComponents\Menu;

class ItemFactory
{
    public function __invoke()
    {
        return new Item();
    }
}

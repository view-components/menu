<?php

namespace ViewComponents\Menu;

use ViewComponents\ViewComponents\Base\ContainerComponentInterface;

interface MenuContainerInterface extends ContainerComponentInterface
{
    /**
     * @param string|null $uri
     * @param string|null $text
     * @param bool $prepend
     * @return $this
     */
    public function makeItem($uri = null, $text = null, $prepend = false);

    /**
     * @param callable $itemFactory
     * @return MenuContainer
     */
    public function setItemFactory(callable $itemFactory);
}

<?php

namespace ViewComponents\Menu;

use ViewComponents\ViewComponents\Base\ViewComponentInterface;

interface MenuItemInterface extends ViewComponentInterface
{
    /**
     * @param string $uri
     * @return $this
     */
    public function setUri($uri);

    /**
     * @return string
     */
    public function getUri();

    /**
     * @return string|null
     */
    public function getText();

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text);
}
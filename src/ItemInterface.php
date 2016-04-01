<?php

namespace ViewComponents\Menu;

interface ItemInterface
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
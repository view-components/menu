<?php

namespace ViewComponents\Menu;

use ViewComponents\ViewComponents\Component\TemplateView;
use ViewComponents\ViewComponents\Rendering\RendererInterface;

class MenuItem extends TemplateView implements MenuItemInterface
{
    const DEFAULT_TEMPLATE = 'menu/item';

    public function __construct($uri = null, $text = null, RendererInterface $renderer = null)
    {
        parent::__construct(null, compact('uri', 'text'), $renderer);
    }

    public function getUri()
    {
        return $this->getDataItem('uri');
    }

    public function setUri($uri)
    {
        $this->setDataItem('uri', $uri);
        return $this;
    }

    public function getText()
    {
        return $this->getDataItem('text');
    }

    public function setText($text)
    {
        $this->setDataItem('text', $text);
        return $this;
    }

    public function getTemplateName()
    {
        $template = parent::getTemplateName();
        if ($template === null) {
            $template = static::DEFAULT_TEMPLATE;
            $this->setTemplateName($template);
        }
        return $template;
    }
}
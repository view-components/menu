<?php

namespace ViewComponents\Menu;

use Closure;
use ViewComponents\ViewComponents\Component\TemplateView;

class Container extends TemplateView
{
    const DEFAULT_TEMPLATE = 'menu/container';

    protected $itemFactory;

    public function getTemplateName()
    {
        $template = parent::getTemplateName();
        if ($template === null) {
            $template = static::DEFAULT_TEMPLATE;
            $this->setTemplateName($template);
        }
        return $template;
    }

    /**
     * @param callable $itemFactory
     * @return Container
     */
    public function setItemFactory(callable $itemFactory)
    {
        $this->itemFactory = $itemFactory;
        return $this;
    }

    protected function getItemFactory()
    {
        if ($this->itemFactory === null) {
            $this->itemFactory = MenuFacade::getItemFactory();
        }
        return $this->itemFactory;
    }

    public function makeItem($uri = null, $text = null, $prepend = false) {
        /** @var ItemInterface $item */
        $item = call_user_func($this->getItemFactory());
        $item
            ->setText($text)
            ->setUri($uri);
        $this->children()->add($item, $prepend);
        return $item;
    }
}

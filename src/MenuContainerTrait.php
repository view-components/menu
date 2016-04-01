<?php

namespace ViewComponents\Menu;

use Nayjest\Tree\NodeCollection;

trait MenuContainerTrait
{
    private $itemFactory;

    /**
     * @return NodeCollection
     */
    abstract public function children();

    /**
     * @param callable $itemFactory
     * @return MenuContainer
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

    public function makeItem($uri = null, $text = null, $prepend = false)
    {
        /** @var MenuItemInterface $item */
        $item = call_user_func($this->getItemFactory());
        $item
            ->setText($text)
            ->setUri($uri);
        $this->children()->add($item, $prepend);
        return $item;
    }
}

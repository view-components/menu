<?php

namespace ViewComponents\Menu;

use ViewComponents\ViewComponents\Component\TemplateView;

class MenuContainer extends TemplateView
{
    use MenuContainerTrait;

    const DEFAULT_TEMPLATE = 'menu/container';

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

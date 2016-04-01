<?php

namespace ViewComponents\Menu;

use RuntimeException;
use ViewComponents\ViewComponents\Storage\ComponentStorage;
use ViewComponents\ViewComponents\Storage\KeyValueStorageInterface;
use ViewComponents\ViewComponents\Service\Services;

class MenuFacade
{
    const MAIN_MENU = 'main';

    /** @var MenuContainer[] */
    protected static $menuSets = [];

    /** @var ComponentStorage[] */
    protected static $storages = [];

    /**
     * Returns menu by id.
     * Creates new menu if menu with specified id not exists.
     *
     * @param string $id
     * @return MenuContainer
     */
    public static function get($id)
    {
        if (array_key_exists($id, self::$menuSets)) {
            return self::$menuSets[$id];
        } elseif ($container = self::load($id)) {
            return $container;
        }
        return self::$menuSets[$id] = self::create();
    }

    /**
     * Returns main menu.
     *
     * @return MenuContainer
     */
    public static function main()
    {
        return self::get(self::MAIN_MENU);
    }

    /**
     * Sets storage for loading and saving menues.
     *
     * @param KeyValueStorageInterface $storage
     */
    public static function useStorage(KeyValueStorageInterface $storage)
    {
        if (!$storage instanceof ComponentStorage) {
            $storage = new ComponentStorage($storage);
        }
        array_unshift(self::$storages, $storage);
    }

    /**
     * Loads menu from storage.
     *
     * @param string $id
     * @return MenuContainer|null
     */
    public static function load($id)
    {
        $key = 'menu_' . $id;
        foreach (self::$storages as $storage) {
            if ($storage->has($key)) {
                return self::$menuSets[$id] = $storage->get($key);
            }
        }
        return null;
    }

    /**
     * Saves menu to storage.
     *
     * @param string $id
     */
    public static function save($id)
    {
        if (!self::hasStorages()) {
            throw new RuntimeException('Can\'t save menu set, no storages configured');
        }
        $key = 'menu_' . $id;
        /** @var ComponentStorage $storage */
        $storage = self::getMenuStorage($id) ?: self::getLastRegisteredStorage();
        $menu = self::get($id);
        $storage->set($key, $menu);
    }

    /**
     * Returns factory of menu items used by default.
     *
     * @return callable
     */
    public static function getItemFactory()
    {
        return Services::get(MenuServiceId::ITEM_FACTORY);
    }

    /**
     * @return callable
     */
    protected static function getContainerFactory()
    {
        return Services::get('menu_container_factory');
    }

    /**
     * Creates menu.
     *
     * @return MenuContainer
     */
    protected static function create()
    {
        return call_user_func(self::getContainerFactory());
    }

    /**
     * @param $id
     * @return null|ComponentStorage
     */
    protected static function getMenuStorage($id)
    {
        $key = 'menu_' . $id;
        foreach (self::$storages as $storage) {
            if ($storage->has($key)) {
                return $storage;
            }
        }
        return null;
    }

    /**
     * @return null|ComponentStorage
     */
    protected static function getLastRegisteredStorage()
    {
        return self::hasStorages() ? array_values(self::$storages)[0] : null;
    }

    protected static function hasStorages()
    {
        return count(self::$storages) > 0;
    }
}

<?php

namespace ViewComponents\Menu;

use RuntimeException;
use ViewComponents\ViewComponents\Storage\ComponentStorage;
use ViewComponents\ViewComponents\Storage\KeyValueStorageInterface;
use ViewComponents\ViewComponents\Service\Services;

class MenuFacade
{
    const MAIN_MENU = 'main';

    /** @var Container[] */
    protected static $menuSets = [];

    /** @var ComponentStorage[] */
    protected static $storages = [];

    /**
     * @param string $id
     * @return Container
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

    public static function main()
    {
        return self::get(self::MAIN_MENU);
    }

    public static function useStorage(KeyValueStorageInterface $storage)
    {
        if (!$storage instanceof ComponentStorage) {
            $storage = new ComponentStorage($storage);
        }
        array_unshift(self::$storages, $storage);
    }

    protected static function getContainerFactory()
    {
        return Services::get('menu_container_factory');
    }

    /**
     * @return callable
     */
    public static function getItemFactory()
    {
        return Services::get('menu_item_factory');
    }

    /**
     * @param string $id
     * @return Container|null
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

    protected static function create()
    {
        return call_user_func(self::getContainerFactory());
    }

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

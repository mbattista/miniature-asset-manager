<?php
declare(strict_types=1);

namespace AssetManager\Helper\Factory;

use AssetManager\Helper\DbHelper;
use Psr\Container\ContainerInterface;

class DbHelperFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $db_helper = new DbHelper();
        $db_helper->setType($config['database']['type']);
        $db_helper->setName($config['database']['name']);
        $db_helper->setHost($config['database']['host']);
        $db_helper->setPassword($config['database']['password']);
        $db_helper->setDatabase($config['database']['database']);
        return $db_helper;
    }
}

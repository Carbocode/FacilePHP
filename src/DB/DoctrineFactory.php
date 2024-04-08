<?php

namespace FacilePHP\DB;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

/**
 * Class that returns different Doctrine objects.
 */
class DoctrineFactory
{
    /**
     * Creates an instance of Doctrine's QueryBuilder
     *
     * @param string $db_host Database host
     * @param string $db_name Database name
     * @param string $db_user Database user
     * @param string $db_password Database password
     *
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public static function createQueryWrapper($db_host, $db_name, #[\SensitiveParameter] $db_user, #[\SensitiveParameter] $db_password)
    {
        $config = new Configuration();
        // Connection parameters
        $connectionParams = [
            'dbname'   => $db_name,
            'user'     => $db_user,
            'password' => $db_password,
            'host'     => $db_host,
            'driver'   => 'pdo_mysql', // or the driver that matches your DBMS
        ];
        $connection = DriverManager::getConnection($connectionParams, $config);

        return $connection->createQueryBuilder();
    }
}

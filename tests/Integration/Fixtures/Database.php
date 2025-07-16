<?php

namespace App\Tests\Integration\Fixtures;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Connections\PrimaryReadReplicaConnection;
use Doctrine\DBAL\DriverManager;
use PDO;
use stdClass;

class Database
{
    public static function getConnectionParameters(): stdClass
    {
        return (object)[
            'host' => getenv('MARIADB_HOST'),
            'port' => getenv('MARIADB_PORT'),
            'database' => getenv('MARIADB_DATABASE'),
            'username' => getenv('MARIADB_USER'),
            'password' => $_ENV['MARIADB_PASSWORD']
        ];
    }

    public static function getPdoConnection(): PDO
    {
        $parameters = self::getConnectionParameters();

        return new PDO(
            'mysql:'
            . 'host=' . $parameters->host
            . ';port=' . $parameters->port
            . ';dbname=' . $parameters->database,
            $parameters->username,
            $parameters->password
        );
    }

    public static function getDbalConnection(?Configuration $config = null): Connection
    {
        $parameters = self::getConnectionParameters();
        return DriverManager::getConnection(
            [
                'dbname' => $parameters->database,
                'user' => $parameters->username,
                'password' => $parameters->password,
                'host' => $parameters->host,
                'port' => $parameters->port,
                'driver' => 'pdo_mysql'
            ],
            $config
        );
    }
}

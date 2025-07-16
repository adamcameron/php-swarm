<?php

namespace App\Service;

use RuntimeException;
use Symfony\Component\Dotenv\Dotenv;

class EnvironmentService
{

    private const string MARIADB_SECRET_FILE = '/run/secrets/mariadb_password';
    private const string APP_SECRET_FILE = '/run/secrets/app_secrets';

    public static function load(): void
    {
        self::loadAppSecrets();
        self::loadMariaDbPassword();
    }

    private static function loadAppSecrets(): void
    {
        if (!file_exists(self::APP_SECRET_FILE)) {
            throw new RuntimeException(
                'App secrets file not found: ' . self::APP_SECRET_FILE
            );
        }

        $dotEnv = new Dotenv();
        $dotEnv->loadEnv(self::APP_SECRET_FILE);
    }

    private static function loadMariaDbPassword(): void
    {
        if (!file_exists(self::MARIADB_SECRET_FILE)) {
            throw new RuntimeException(
                'MariaDB password file not found: ' . self::MARIADB_SECRET_FILE
            );
        }

        $raw = file_get_contents(self::MARIADB_SECRET_FILE);
        if ($raw === false) {
            throw new RuntimeException(
                'Failed to read MariaDB password from: ' . self::MARIADB_SECRET_FILE
            );
        }
        $password = trim($raw);

        $_ENV['MARIADB_PASSWORD'] = $password;
        $_SERVER['MARIADB_PASSWORD'] = $password;
    }
}

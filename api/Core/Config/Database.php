<?php

declare(strict_types=1);

namespace Core\Config;

/**
 * Mysql database config
 */
class Database
{
    public static string $DB_SERVER = 'database.cc.localhost';
    public static string $DB_NAME = 'course_catalog';
    public static string $DB_USERNAME = 'test_user';
    public static string $DB_PASSWORD = 'test_password';
}
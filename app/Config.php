<?php

namespace App;

class Config
{
    protected array $config = [];

    public function __construct()
    {
        $this->config = [
            'db' => [
                'host'     => $_ENV['DB_HOST'],
                'user'     => $_ENV['DB_USER'],
                'pass'     => $_ENV['DB_PASS'],
                'database' => $_ENV['DB_DATABASE'],
                'driver'   => $_ENV['DB_DRIVER'] ?? 'mysql',
            ],
        ];
    }

    public function __get(string $name)
    {
        return $this->config[$name] ?? null;
    }

    public function extract(): array
    {
        return $this->config['db'];
    }
}
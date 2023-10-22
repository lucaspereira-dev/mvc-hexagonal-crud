<?php

namespace Tests\Integrations;

use App\Persistence\Connections\ConnectionInterface;
use App\Persistence\Connections\MysqlPdo;
use PHPUnit\Framework\TestCase;

final class MysqlPdoTest extends TestCase
{
    private ConnectionInterface $db;
    protected function setUp(): void
    {
        $this->db = new MysqlPdo();
    }

    /**
     * @test
     */
    public function shouldConnectedSuccess(): void
    {
        [$result] = $this->db->query('SELECT 1');
        $this->assertEquals(['1' => 1], $result);
    }
}

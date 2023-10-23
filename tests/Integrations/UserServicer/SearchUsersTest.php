<?php

namespace Tests\Integrations\UserServiceImpl;

use App\Persistence\Models\UserDaoAdapterMemory;
use Core\Interfaces\UserService;
use Core\Entities\User;
use Core\Exceptions\UserException;
use PHPUnit\Framework\TestCase;
use Core\Services\UserServiceImpl;

final class SearchUsersTest extends TestCase
{

    private UserService $serviceUser;
    private $payloads = [
        [
            'id' => '43210',
            'name' => 'Henrique freitas',
            'email' => 'usuario@email.com.br',
            'password' => 'chapeuzinho@vermelho123',
            'birthday' => '2000-10-10'
        ],
        [
            'id' => '01234',
            'name' => 'Lucas Pereira',
            'email' => 'lucaspereira@test.com.br',
            'password' => '1234@senha',
            'birthday' => '1998-01-28'
        ]
    ];

    protected function setUp(): void
    {
        $this->serviceUser = new UserServiceImpl(new UserDaoAdapterMemory());
        $this->createDefaultUser();
    }

    /**
     * @test
     * Testa a busca de um usuário pelo ID.
     */
    public function getUserById(): void
    {
        $user = $this->serviceUser->findById('43210');
        $this->assertNotNull($user);
        $this->assertEquals('Henrique freitas', $user->name);
    }

    /**
     * @test
     * Testa a busca de um usuário pelo e-mail.
     */
    public function getUserByEmail(): void
    {
        $user = $this->serviceUser->findByEmail('usuario@email.com.br');
        $this->assertNotNull($user);
        $this->assertEquals('Henrique freitas', $user->name);
    }

    /**
     * @test
     * Testa a busca de todos os usuários.
     */
    public function getAllUsers(): void
    {
        $expectedUsers = array_map(fn ($user) => new User(
            $user["id"],
            $user["name"],
            $user["email"],
            $user["password"],
            $user["birthday"]
        ), $this->payloads);
        $users = $this->serviceUser->findAll();
        $this->assertNotEmpty($users);
        $this->assertEquals($expectedUsers, $users);
    }

     /**
     * @test
     * Não encontrado ID do usuário
     */
    public function idUserNotFound(): void
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nenhum usuário identificado com este ID');
        $this->expectExceptionCode(404);
        $this->serviceUser->findById('00000');
    }

    /**
     * @test
     * Usuário não encontrado
     */
    public function emailUserNotFound(): void
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('E-mail informado não cadastrado');
        $this->expectExceptionCode(404);
        $this->serviceUser->findByEmail('00000@email.com');
    }

    /**
     * Cria uma lista de usuários padrões para os testes.
     */
    public function createDefaultUser(): void
    {
        foreach($this->payloads as $payload) {
            $this->serviceUser->create($payload);
        }
    }
}

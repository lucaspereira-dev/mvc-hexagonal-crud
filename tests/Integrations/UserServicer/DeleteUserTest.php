<?php

namespace Tests\Integrations\UserServiceImpl;

use App\Persistence\Models\UserDaoAdapterMemory;
use Core\Interfaces\UserService;
use Core\Exceptions\UserException;
use PHPUnit\Framework\TestCase;
use Core\Services\UserServiceImpl;

final class DeleteUserTest extends TestCase
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
     * Deve excluir um usuário com sucesso
     */
    public function shouldDeletedUserWithSuccess(): void
    {
        $this->serviceUser->delete('01234');
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nenhum usuário identificado com este ID');
        $this->expectExceptionCode(404);
        $this->serviceUser->findById('01234');
    }

     /**
     * @test
     * Deve falhar ao excluir usuário que não existe
     */
    public function shouldFailDeletedUserNotExisting(): void
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nenhum usuário identificado com este ID');
        $this->expectExceptionCode(404);
        $this->serviceUser->delete('0000');
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

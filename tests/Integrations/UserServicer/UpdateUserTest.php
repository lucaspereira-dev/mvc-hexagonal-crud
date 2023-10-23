<?php

namespace Tests\Integrations\UserServiceImpl;

use App\Persistence\Models\UserDaoAdapterMemory;
use Core\Interfaces\UserService;
use Core\Exceptions\UserException;
use PHPUnit\Framework\TestCase;
use Core\Services\UserServiceImpl;

final class UpdateUserTest extends TestCase
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
     * Deve atualizar um usuário com sucesso
     */
    public function shouldUpdateUserWithSuccess(): void
    {
        $user = [
            'id'        => '43210',
            'name'      => 'Nome de usuário teste',
            'birthday'  => '2011-09-11'
        ];
        $this->serviceUser->update($user);
        $userActual = $this->serviceUser->findById($user['id']);
        $this->assertEquals($user['name'], $userActual->name);
        $this->assertEquals($user['birthday'], $userActual->birthday);
    }

     /**
     * @test
     * Deve falhar ao atualizar usuário que não existe
     */
    public function shouldFailUpdateUserNotExisting(): void
    {
        $user = [
            'id'   => '0000',
            'name' => 'Atualização de usuário'
        ];
        $this->expectException(UserException::class);
        $this->expectExceptionMessage('Nenhum usuário identificado com este ID');
        $this->expectExceptionCode(404);
        $this->serviceUser->update($user);
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

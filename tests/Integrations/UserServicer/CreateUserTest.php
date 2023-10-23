<?php

namespace Tests\Integrations\UserServiceImpl;

use App\Persistence\Models\UserMemory;
use Core\Interfaces\UserService;
use Core\Exceptions\UserException;
use PHPUnit\Framework\TestCase;
use Core\Services\UserServiceImpl;

final class CreateUserTest extends TestCase {

    private UserService $serviceUser;

    protected function setUp(): void
    {
        $this->serviceUser = new UserServiceImpl(new UserMemory());
    }

    /**
     * Deveria criar um usuário com sucesso
     * @test
     */
    public function shouldCreateUserSuccess(): void
    {
        $userPayload = [
            'name' => 'Henrique freitas',
            'email' => 'usuario@email.com.br',
            'password' => 'chapeuzinho@vermelho123',
            'birthday' => '2000-10-10'
        ];

        $this->serviceUser->create($userPayload);
        $userCreated = $this->serviceUser->findByEmail($userPayload['email']);
        $actualValues = [
            'name' => $userCreated->name,
            'email' => $userCreated->email,
            'password' => $userCreated->password,
            'birthday' => $userCreated->birthday
        ];

        $this->assertEquals($userPayload, $actualValues);
    }

    /**
     * Deve retornar uma lista de erros ao criar o usuário
     * @return void
     * @test
     */
    public function ShouldReturnListOfErrorsWhenCreatingUser(): void 
    {
        $badPayload = [
            'name'      => '  ',
            'email'     => 'usuario@$%1234.com',
            'password'  => ' ',
            'birthday'  => '2000-14-10'
        ];

        $exceptionErrors = [
            'errors' => [
                'name' => 'O nome de usuário não pode estar vazio',
                'email' => 'Argumento de e-mail inválido',
                'password' => 'Senha não pode ser vazio',
                'birthday' => 'Data informada não é valida'
            ]
        ];
        try {
            $this->serviceUser->create($badPayload);
            $this->fail('Exception trigger failure');
        } catch (UserException $e) {
            $actual = json_decode($e->getMessage(), true);
            $this->assertEquals($exceptionErrors, $actual);
        }
    }

    /**
     * Valida resposta de errors ao criar um usuário
     * @dataProvider shouldFailedInCreateUserDataProvider
     * @return void
     * @test
     */
    public function shouldFailedInCreateUser(
        array $payload,
        string $exceptionMessage
    ): void
    {
        $this->expectException(UserException::class);
        $this->expectExceptionMessage($exceptionMessage);
        $this->serviceUser->create($payload);
    }

    /**
     * Provedor de dados de cenários de error na criação de usuários
     * @return array
     */
    public static function shouldFailedInCreateUserDataProvider(): array
    {
        return [
            'E-mail is invalid' => [
                'payload' => [
                    'name'      => 'Henrique freitas',
                    'email'     => 'usuario@$54.com',
                    'password'  => 'chapeuzinho@vermelho123',
                    'birthday'  => '2000-10-10'
                ],
                'exceptionMessage' => json_encode(['errors' => ['email' => 'Argumento de e-mail inválido']])
            ],
            'Name must not be empty' => [
                'payload' => [
                    'name'      => '   ',
                    'email'     => 'usuario1@email.com',
                    'password'  => 'chapeuzinho@vermelho123',
                    'birthday'  => '2000-10-10'
                ],
                'exceptionMessage' => json_encode(['errors' => ['name' => 'O nome de usuário não pode estar vazio']])
            ],
            'Password must not be empty' => [
                'payload' => [
                    'name'      => 'Henrique freitas',
                    'email'     => 'usuario2@email.com',
                    'password'  => '  ',
                    'birthday'  => '2000-10-10'
                ],
                'exceptionMessage' => json_encode(['errors' => ['password' => 'Senha não pode ser vazio']])
            ],
            'Invalid date birthday' => [
                'payload' => [
                    'name'      => 'Henrique freitas',
                    'email'     => 'usuario3@email.com',
                    'password'  => 'chapeuzinho@vermelho123',
                    'birthday'  => '2000-14-10'
                ],
                'exceptionMessage' => json_encode(['errors' => ['birthday' => 'Data informada não é valida']])
            ]
        ];
    }

}

<?php

namespace App\Controllers;

use Core\Exceptions\UserException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Core\Interfaces\UserService;
use Exception;

final class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function createUser(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();
            $this->userService->create($data);
            return $this->response($response, ['message' => 'Usuário criado com sucesso'], 201);
        } catch (UserException $e) {
            $exception = json_decode($e->getMessage(), true);
            return $this->response($response, [
                'message' => 'Não foi possível criar usuário',
                'errors' => $exception['errors']
            ], 400);
        } catch (Exception $e) {
            return $this->response($response, [
                'message' => 'Não conseguimos completar esta ação'
            ], $e->getCode());
        }
    }

    public function updateUser(Request $request, Response $response, array $args): Response
    {
        try {
            $data = $request->getParsedBody();
            $data['id'] = $args['id'];
            $this->userService->update($data);
            return $this->response($response, ['message' => 'Usuário atualizado com sucesso'], 200);
        } catch (UserException $e) {
            $exception = json_decode($e->getMessage(), true);
            return $this->response($response, [
                'message' => 'Não foi possível atualizado usuário',
                'errors' => $exception['errors'] ?? []
            ], 400);
        } catch (Exception $e) {
            return $this->response($response, [
                'message' => 'Não conseguimos completar esta ação'
            ], $e->getCode());
        }
    }

    public function deleteUser(Request $request, Response $response, array $args): Response
    {
        $this->userService->delete($args['id']);

        return $this->response($response, ['message' => 'Usuário excluído com sucesso'], 200);
    }

    public function getUserById(Request $request, Response $response, array $args): Response
    {
        $user = $this->userService->findById($args['id']);
        $outputUser = [
            'id' => (string)$user->id,
            'name' => (string)$user->name,
            'email' => (string)$user->email,
            'password' => (string)$user->password,
            'birthday' => (string)$user->birthday
        ];
        return $this->response($response, $outputUser, 200);
    }

    public function getAllUsers(Request $request, Response $response): Response
    {
        $users = $this->userService->findAll();
        $outputUsers = array_map(fn ($user) => [
            'id' => (string)$user->id,
            'name' => (string)$user->name,
            'email' => (string)$user->email,
            'password' => (string)$user->password,
            'birthday' => (string)$user->birthday
        ], $users);
        return $this->response($response, $outputUsers);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/24/18
 * Time: 2:59 PM
 */

namespace Segments\Nyo\Services\Authorization;


use App\Config\Config;
use App\Helpers\KeyValueStorageInterface;
use App\Http\SessionInterface;
use Segments\Nyo\DAL\Repository\User\UserRepositoryInterface;
use Segments\Nyo\Model\User\UserModel;

class AuthorizationService implements AuthorizationServiceInterface
{

    const USER_MODEL_KEY = 'user_model';

    /**
     * Позволяет хранить и извлекать значения по ключу
     *
     * @var KeyValueStorageInterface $storage
     */
    protected $storage;

    /** @var UserRepositoryInterface $userRepository */
    protected $userRepository;

    public function __construct(KeyValueStorageInterface $storage, UserRepositoryInterface $userRepository)
    {
        $this->storage = $storage;
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $user_id
     * @param AuthorizationTypeEnum $auth_type
     * @return mixed
     * @throws AuthorizationException
     */
    public function authorizeByUserId(int $user_id, AuthorizationTypeEnum $auth_type) : UserModel
    {
        //пользователь найден в бд
        $user_found = $this->userRepository->getUserById($user_id, $auth_type);
        if ($user_found->userId == 0) {
            throw new AuthorizationException(AuthorizationExceptionCause::NOT_REGISTERED());
        }

        //проверим авторизован ли пользователь уже - если пользователь уже авторизован - бросаем ошибку
        if (empty($this->storage->get(self::USER_MODEL_KEY)) === false) {
            throw new AuthorizationException(AuthorizationExceptionCause::ALREADY_AUTHORIZED());
        }

        //иначе сохраняем user_model в переданное хранилище(storage)
        $this->storage->set(self::USER_MODEL_KEY, $user_found);

        if (is_a($this->storage, SessionInterface::class)) {
            /** @var $session SessionInterface */
            $session = $this->storage;
            $session->regenerateSession();
        }

        return $user_found;
    }

    /**
     * Создает токен на основе входящего параметра $seed
     *
     * @param string $seed
     * @return string
     */
    public function createToken(string $seed): string
    {
        return password_hash(password_hash($seed, PASSWORD_BCRYPT, ['salt' => Config::SALT_GLOBAL]),
            PASSWORD_BCRYPT);
    }

    /**
     * @param string $token
     * @return UserModel
     */
    public function authorizeByToken(string $token): UserModel
    {
        return $this->storage->get($token);
    }

    /**
     * Авторизован ли пользователь
     *
     * @return bool
     */
    public function isAuthorized()
    {
        return empty($this->storage->get(self::USER_MODEL_KEY)) === false;
    }
}
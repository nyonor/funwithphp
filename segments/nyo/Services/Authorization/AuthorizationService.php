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
use App\Ioc\Ioc;
use App\Services\ServiceException;
use Segments\Nyo\DAL\Repository\UserRepositoryInterface;
use Segments\Nyo\Model\UserModel;

class AuthorizationService implements AuthorizationServiceInterface
{

    const USER_MODEL_KEY = 'user_model';

    /**
     * Позволяет хранить и извлекать значения по ключу
     *
     * @var KeyValueStorageInterface $storage
     */
    protected $storage;

    public function __construct(KeyValueStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param int $user_id
     * @param AuthorizationTypeEnum $auth_type
     * @throws ServiceException
     */
    public function authorizeByUserId(int $user_id, AuthorizationTypeEnum $auth_type)
    {
        /** @var UserRepositoryInterface $user_repo */
        $user_repo = Ioc::factory(UserRepositoryInterface::class);

        //пользователь найден в бд
        $user_found = $user_repo->getUserById($user_id, $auth_type);
        if (empty($user_found)) {
            throw new ServiceException('User is not registered!');
        }

        //проверим авторизован ли пользователь уже - если пользователь уже авторизован - бросаем ошибку
        if (empty($this->storage->get(self::USER_MODEL_KEY)) === false) {
            throw new ServiceException('User already authorized!');
        }

        //иначе сохраняем user_model в переданное хранилище(storage)
        $this->storage->set(self::USER_MODEL_KEY, $user_found);

        //обновляем сессию
        self::regenerateSession();
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
     * Регенерирует сессию
     *
     * @return void
     */
    public static function regenerateSession()
    {
        //обновляем сессию
        session_regenerate_id();
    }

    /**
     * @param string $token
     * @return UserModel
     */
    public function authorizeByToken(string $token): UserModel
    {
        return $this->storage->get($token);
    }
}
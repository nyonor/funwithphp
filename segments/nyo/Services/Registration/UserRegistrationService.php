<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/28/18
 * Time: 7:55 PM
 */

namespace Segments\Nyo\Services\Registration;


use App\DAL\RepositoryInterface;
use App\Ioc\Ioc;
use App\Services\ServiceException;
use App\Services\ServiceWithRepositoryInterface;
use Segments\Nyo\DAL\Repository\UserRepositoryInterface;
use Segments\Nyo\Model\UserModel;
use Segments\Nyo\Services\Authorization\AuthorizationTypeEnum;
use Segments\Nyo\Services\Authorization\Vk\VkAuthorizationServiceInterface;

class UserRegistrationService implements UserRegistrationServiceInterface, ServiceWithRepositoryInterface
{

    /**
     * @param string $authorization_type
     * @param int|null $user_id
     * @return UserModel
     * @throws \Exception
     */

    /** @var AuthorizationTypeEnum $currentAuthorizationType */
    protected $currentAuthorizationType;

    /**
     * Регистрирует пользователя в системе.
     * Передавая
     *
     * @param string $authorization_type
     * @param int $user_id
     * @return UserModel
     * @throws ServiceException
     */
    public function register(string $authorization_type, int $user_id = null): UserModel
    {
        $this->currentAuthorizationType = $authorization_type;

        //если пользователь регистрируется через ВК
        if ($authorization_type == AuthorizationTypeEnum::EXTERNAL_VK) {
            $user_model = $this->registerAsVkUser($user_id);
            return $user_model;
        }

        throw new ServiceException('Not supported authorization type!');
    }

    /**
     * Регистрирует пользователя с помощью vk_client_id - идентификатора
     * пользователя соц. сети ВКОНТАКТЕ. и access_token - идентификатора для запросов
     * access_token должен быть валидным для запросов.
     *
     * @param $vk_client_id
     * @param $access_token
     * @param VkAuthorizationServiceInterface $vk_auth_service
     * @return UserModel
     * @throws ServiceException
     */
    public function registerAsVkUser($vk_client_id, $access_token, VkAuthorizationServiceInterface $vk_auth_service) : UserModel
    {
        //найдем такого пользователя по id
        /** @var UserRepositoryInterface $user_repository */
        $user_repository = Ioc::factory(UserRepositoryInterface::class);
        $registered_user_model = $user_repository->getUserById($vk_client_id, $this->currentAuthorizationType);

        //если такой пользователь уже зарегистрирован, бросаем исключение
        if (empty($registered_user_model) == false) {
            throw new ServiceException('VK user with provided id is already registered!');
        }

        //проверим валидность переданных аргументов
        $vk_data_is_valid = $vk_auth_service->checkIsValid($vk_client_id, $access_token);

        if ($vk_data_is_valid == false) {
            throw new ServiceException('Vk data for registration is not valid!');
        }

        return $registered_user_model;
    }
}
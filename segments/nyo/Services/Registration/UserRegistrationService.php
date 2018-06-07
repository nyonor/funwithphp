<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/28/18
 * Time: 7:55 PM
 */

namespace Segments\Nyo\Services\Registration;


use App\DAL\RepositoryInterface;
use function App\Helpers\Globals\container;
use App\Ioc\Ioc;
use App\Services\ServiceException;
use App\Services\ServiceWithRepositoryInterface;
use Segments\Nyo\DAL\Repository\UserRepositoryInterface;
use Segments\Nyo\Model\UserModel;
use Segments\Nyo\Services\Authorization\AuthorizationTypeEnum;
use Segments\Nyo\Services\Authorization\Vk\VkAuthorizationServiceInterface;

class UserRegistrationService implements UserRegistrationServiceInterface
{
    /**
     * Регистрирует пользователя с помощью vk_client_id - идентификатора
     * пользователя соц. сети ВКОНТАКТЕ. и access_token - идентификатора для запросов
     * access_token должен быть валидным для запросов.
     *
     * @param $vk_client_id
     * @param $access_token
     * @param VkAuthorizationServiceInterface $vk_auth_service
     * @return UserModel
     * @throws UserRegistrationException
     */
    public function registerAsVkUser($vk_client_id,
                                     $access_token,
                                     VkAuthorizationServiceInterface $vk_auth_service) : UserModel
    {
        $vk_auth_type = AuthorizationTypeEnum::EXTERNAL_VK();

        //найдем такого пользователя по id
        /** @var UserRepositoryInterface $user_repository */
        $user_repository = container()->create('user_repository');
        $user_model = $user_repository->getUserById($vk_client_id, $vk_auth_type);

        //если такой пользователь уже зарегистрирован, бросаем исключение
        if (empty($user_model) == false) {
            throw new UserRegistrationException(UserRegistrationExceptionCause::ALREADY_REGISTRED());
        }

        //проверим валидность переданных аргументов
        $vk_data_is_valid = $vk_auth_service->checkIsValid($vk_client_id, $access_token);
        if ($vk_data_is_valid == false) {
            throw new UserRegistrationException(UserRegistrationExceptionCause::DATA_IS_NOT_VALID());
        }

        //получим все данные для регистрации
        $registered_user_model = $user_repository->addUser($vk_auth_type, $user_model);

        return $registered_user_model;
    }
}
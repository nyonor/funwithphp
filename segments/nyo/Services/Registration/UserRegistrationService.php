<?php
/**
 * Регистрация пользователей в системе
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/28/18
 * Time: 7:55 PM
 */

namespace Segments\Nyo\Services\Registration;


use App\DAL\RepositoryException;
use App\DAL\RepositoryInterface;
use App\Helpers\Exceptions\ExceptionCause;
use function App\Helpers\Globals\container;
use App\Ioc\Ioc;
use App\Services\ServiceException;
use App\Services\ServiceWithRepositoryInterface;
use Segments\Nyo\DAL\Repository\User\UserRepositoryInterface;
use Segments\Nyo\Model\User\UserModel;
use Segments\Nyo\Services\Authorization\AuthorizationTypeEnum;
use Segments\Nyo\Services\Authorization\Vk\VkAuthorizationServiceInterface;

class UserRegistrationService implements UserRegistrationServiceInterface
{
    /**
     * Регистрирует пользователя с помощью vk_client_id - идентификатора
     * пользователя соц. сети ВКОНТАКТЕ. и access_token - идентификатора для запросов
     * access_token должен быть валидным для запросов.
     *
     * todo тех-долг - метод нуждается в доработке, как и вся система авторизации
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
        if ($user_model->userId > 0) {
            throw new UserRegistrationException(UserRegistrationExceptionCause::ALREADY_REGISTRED());
        }

        //todo
        //проверим валидность переданных аргументов
//        $vk_data_is_valid = $vk_auth_service->checkIsValid($vk_client_id, $access_token);
//        if ($vk_data_is_valid == false) {
//            throw new UserRegistrationException(UserRegistrationExceptionCause::DATA_IS_NOT_VALID());
//        }

        //получаем минимальные данные для регистрации в системе
        try {
            $user_data = $vk_auth_service->getUserData(
                $vk_client_id,
                $access_token,
                [
                    'photo_50',
                    'deactivated',
                ]
            );

            $user_data = $user_data[0];

            //если vk_client_id не равен возвращенному, то это фейк и он не подходит
            if ($user_data['id'] !== $vk_client_id) {
                throw new \Exception('Vk client id is not corresponding with given access token!');
            }

            //если пользователь деактивирован или забанен, то он не подходит
            if ($user_data['deactivated'] == 'deleted' || $user_data['deactivated'] == 'banned') {
                throw new \Exception('Vk page is not verified, blocked or deactivated!');
            }

            if (!empty($user_data['photo_50'])) {
                $user_model->pictureMiniPath = $user_data['photo_50'];
            }

            $user_model->firstName = $user_data['first_name'];
            $user_model->secondName = $user_data['last_name'];

        } catch (\Exception $e) {
            throw new UserRegistrationException(UserRegistrationExceptionCause::DATA_IS_NOT_VALID());
        }

        try{
            //заполним модель пользователя нужными данными
            $user_model->vkUserId = $vk_client_id;

            //добавляем юзера в репозиторий
            $registered_user_model = $user_repository->addUser($vk_auth_type, $user_model);

            return $registered_user_model;
        } catch (RepositoryException $e) {
            throw new UserRegistrationException(ExceptionCause::INTERNAL_ERROR(), $e);
        }
    }
}
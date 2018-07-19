<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/24/18
 * Time: 6:56 PM
 */

namespace Segments\Nyo\DAL\Repository\User;


use App\DAL\AbstractRepository;
use App\DAL\DbConnectionException;
use App\DAL\RepositoryException;
use App\DAL\RepositoryExceptionCause;
use function App\Helpers\Globals\container;
use Segments\Nyo\Model\User\UserModel;
use Segments\Nyo\Services\Authorization\AuthorizationTypeEnum;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    const INTERNAL_USER_TABLE_NAME = 'user';
    const VK_USER_TABLE_NAME = 'user_vk';

    /**
     * Найти пользователя по его id и типу авторизации ($auth_type)
     * Если пользователь не будет найден, будет возвращена пустая модель типа UserModel
     *
     * @param int $id
     * @param AuthorizationTypeEnum $auth_type
     * @return UserModel
     */
    public function getUserById(int $id, AuthorizationTypeEnum $auth_type): UserModel
    {
        $result = container()->create('user_model');

        //$user_table_name = $this->getUserTableNameByAuthType($auth_type);
        //$user_table_pk = $user_table_name . '_id';

        //$sql = 'SELECT * FROM ' . $user_table_name . ' WHERE ' . $user_table_pk . ' = :pk_id';
        $sql = 'SELECT *, uv.registration_date as `user_vk_registration_date` FROM user as u
                LEFT JOIN user_vk as uv on u.user_id = uv.user_id
                LEFT JOIN user_details as ud on u.user_id = ud.user_id';

        if ($auth_type == AuthorizationTypeEnum::EXTERNAL_VK) {
            $sql .= ' WHERE uv.user_vk_id = :pk_id';
        }

        if ($auth_type == AuthorizationTypeEnum::INTERNAL) {
            $sql .= ' WHERE u.user_id = :pk_id';
        }

        $this->dbConnection
                ->setQuery($sql)
                ->setParameters([':pk_id' => $id])
                ->prepareQuery();

        /** @var UserModel $db_result */
        $db_result = $this->dbConnection->getOneAsAssoc();
        if (empty($db_result)) {
            return $result; //TODO CHECK TODAY - need to create method which maps model to db and backwards
        }

        $result->userId = $db_result['user_id'];
        if ($auth_type->getValue() == AuthorizationTypeEnum::EXTERNAL_VK) {
            $result->vkUserId = $db_result['user_vk_id'];
        }
        $result->vkRegistrationDate = $db_result['user_vk_registration_date'];
        $result->registrationDate = $db_result['registration_date'];
        $result->secondName = $db_result['second_name'];
        $result->firstName = $db_result['first_name'];
        $result->pictureMiniPath = $db_result['picture_mini_path'];
        $result->email = $db_result['email'];
        $result->nickName = $db_result['nick_name'];

        return $result;
    }

    /**
     * Возвращает название таблицы в бд по переданному
     * типу авторизации пользователя
     *
     * @param AuthorizationTypeEnum $auth_type
     * @return null|string
     */
    protected function getUserTableNameByAuthType(AuthorizationTypeEnum $auth_type)
    {
        switch ($auth_type->getValue())
        {
            case (AuthorizationTypeEnum::INTERNAL):
                return self::INTERNAL_USER_TABLE_NAME;
                break;
            case (AuthorizationTypeEnum::EXTERNAL_VK):
                return self::VK_USER_TABLE_NAME;
                break;
            default;
                return null;
        }
    }

    /**
     * Добавить нового пользователя по типу авторизации
     *
     * @param AuthorizationTypeEnum $auth_type
     * @param UserModel $user_model
     * @return UserModel
     * @throws RepositoryException
     */
    public function addUser(AuthorizationTypeEnum $auth_type, UserModel $user_model) : UserModel
    {
        try{
            //проверка все ли нужные поля находятся в модели
            if (!empty($user_model->userId)) {
                throw new RepositoryException(RepositoryExceptionCause::ENTITY_ALREADY_EXISTS());
                //todo
            }

            //стартуем транзакцию
            $this->dbConnection->beginTransaction();

            //создаем нового пользователя
//            $this->dbConnection->setParameters([
//                ':registration_date' => date('now')
//            ]);

            $now = date("Y-m-d H:i:s");

            $user_id = $this->dbConnection
                                ->setParameters([
                                    ':registration_date' => $now
                                ])
                                ->insert('user');

            if ($user_id == 0) {
                throw new RepositoryException('User was not created!');
            }

            //добавим данные по вк, если есть
            if ($auth_type->getValue() == AuthorizationTypeEnum::EXTERNAL_VK) {
                $this->dbConnection
                        ->setParameters([
                            ':user_id' => $user_id,
                            ':user_vk_id' => $user_model->vkUserId
                        ])
                        ->insert('user_vk');
            }

            //добавим данные в user_details
            $this->dbConnection
                    ->setParameters([
                        ':user_id' => $user_id,
                        ':picture_mini_path' => $user_model->pictureMiniPath,
                        ':first_name' => $user_model->firstName,
                        ':second_name' => $user_model->secondName,
                        ':email' => $user_model->email
                    ])
                    ->insert('user_details');

            if ($user_id === false) {
                $this->dbConnection->rollbackTransaction();
                return $user_model;
            }

            //коммитим транзакцию
            $this->dbConnection->commitTransaction();

            if (!empty($user_vk_id)) {
                $user_model->vkUserId = $user_vk_id;
            }

            $user_model->registrationDate = $now;
            $user_model->vkRegistrationDate = $now;
            $user_model->userId = $user_id;

            return $user_model;

        } catch (DbConnectionException $e) {
            //если перехватываем ошибку - откатываем транзакцию
            $this->dbConnection->rollbackTransaction();
            throw new RepositoryException(null, $e);
        }
    }
}
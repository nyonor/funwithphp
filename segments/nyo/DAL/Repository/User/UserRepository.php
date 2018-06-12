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
        $result = new UserModel();

        $user_table_name = $this->getUserTableNameByAuthType($auth_type);
        $user_table_pk = $user_table_name . '_id';

        $this->dbConnection
                ->setQuery('SELECT * FROM ' . $user_table_name . ' WHERE ' . $user_table_pk . ' = :user_id')
                ->setParameters([':user_id' => $id]);

        /** @var UserModel $db_result */
        $db_result = $this->dbConnection->getOneAs(UserModel::class);
        if (!empty($db_result)) {
            $result = $db_result;
        }

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
            $user_id = $this->dbConnection->insert('user');

            //добавим данные по вк, если есть
            if ($auth_type->getValue() == AuthorizationTypeEnum::EXTERNAL_VK) {
                $this->dbConnection
                        ->setParameters([':user_id' => $user_id])
                        ->insert('user_vk');
            }

            //добавим данные в user_details
            $user_details_id = $this->dbConnection
                    ->setParameters([
                        ':user_id' => $user_id,
                        ':picture_mini_path' => $user_model->pictureMiniPath,
                        ':first_name' => $user_model->firstName,
                        ':second_name' => $user_model->secondName,
                        ':email' => $user_model->email
                    ])
                    ->insert('user_details');

            //коммитим транзакцию
            $this->dbConnection->commitTransaction();
        } catch (DbConnectionException $e) {
            //если перехватываем ошибку - откатываем транзакцию
            $this->dbConnection->rollbackTransaction();
        }
    }
}
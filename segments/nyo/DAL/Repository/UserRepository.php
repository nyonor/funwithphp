<?php
/**
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/24/18
 * Time: 6:56 PM
 */

namespace Segments\Nyo\DAL\Repository;


use App\DAL\AbstractRepository;
use App\DAL\RepositoryException;
use Segments\Nyo\Model\UserModel;
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
     * @param array $user_data
     * @return UserModel
     */
    public function addUser(AuthorizationTypeEnum $auth_type, array $user_data): UserModel
    {
        if ($auth_type->getValue() == AuthorizationTypeEnum::EXTERNAL_VK) {
            $this->addExternalUserData();
        }

        $this->dbConnection->beginTransaction();

        $this->dbConnection->setQuery('INSERT INTO ' . self::INTERNAL_USER_TABLE_NAME . '(:registration_date)VALUE()');
    }
}
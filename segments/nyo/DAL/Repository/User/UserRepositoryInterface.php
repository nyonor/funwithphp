<?php
/**
 * Интерфейс репозитория сущности user.
 * Реализовав его, класс получит возможности, которые отвечают
 * требованиям приложения для манипуляций с данной сущностью в рамках
 * бизнес модели.
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/24/18
 * Time: 6:32 PM
 */

namespace Segments\Nyo\DAL\Repository\User;


use App\DAL\RepositoryInterface;
use Segments\Nyo\Model\User\UserModel;
use Segments\Nyo\Services\Authorization\AuthorizationTypeEnum;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Найти пользователя по его id и типу авторизации ($auth_type)
     * Если пользователь не будет найден, будет возвращена пустая модель типа UserModel
     *
     * @param int $id
     * @param AuthorizationTypeEnum $auth_type
     * @return UserModel
     */
    public function getUserById(int $id, AuthorizationTypeEnum $auth_type) : UserModel;

    /**
     * Добавить нового пользователя по типу авторизации
     *
     * @param AuthorizationTypeEnum $auth_type
     * @param UserModel $user_model
     * @return UserModel
     */
    public function addUser(AuthorizationTypeEnum $auth_type, UserModel $user_model) : UserModel;
}
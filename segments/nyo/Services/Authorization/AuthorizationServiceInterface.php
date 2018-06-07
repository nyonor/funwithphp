<?php
/**
 * Авторизации в системе
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/24/18
 * Time: 2:58 PM
 */

namespace Segments\Nyo\Services\Authorization;


use Segments\Nyo\Model\UserModel;

interface AuthorizationServiceInterface
{
    /**
     * @param string $token
     * @return UserModel
     */
    public function authorizeByToken(string $token) : UserModel;

    /**
     * Создает токен на основе входящего параметра $seed
     *
     * @param string $seed
     * @return string
     */
    public function createToken(string $seed) : string;

    /**
     * Авторизует пользователя по его $user_id и типу авторизации $auth_type.
     *
     * @param int $user_id
     * @param AuthorizationTypeEnum $auth_type
     * @return mixed
     * @throws AuthorizationException
     */
    public function authorizeByUserId(int $user_id, AuthorizationTypeEnum $auth_type) : UserModel;
}
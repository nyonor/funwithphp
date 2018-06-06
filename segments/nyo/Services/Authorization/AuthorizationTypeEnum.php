<?php
/**
 * Используеется для хранения типов авторизации
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/24/18
 * Time: 6:18 PM
 */

namespace Segments\Nyo\Services\Authorization;


use App\Helpers\Type\EnumParodyInterface;

class AuthorizationTypeEnum implements EnumParodyInterface
{
    // внутренняя авторизация, соотносится с таблице user
    public const INTERNAL = 'internal';

    // внешняя авторизация через VK API, соотносится с таблицей user_vk
    public const EXTERNAL_VK = 'vk';

    /**
     * Тип авторизации ассоциированный с экземпляром класса
     * @var string $authType
     */
    protected $authType;


    /**
     * Входной параметр будет принят в качестве
     * типа авторизации ассоциированный с экземпляром класс
     *
     * AuthorizationTypeEnum constructor.
     * @param string $type
     */
    public function __construct(string $type)
    {
        if ($type == self::INTERNAL) {
            $this->authType = $type;
        }

        if ($type == self::EXTERNAL_VK) {
            $this->authType = $type;
        }
    }

    /**
     * Извлекает значение из экземпляра.
     * Данное значение например может быть установлено при помощи
     * конструктора класс, реализующего интерфейс.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->authType;
    }
}
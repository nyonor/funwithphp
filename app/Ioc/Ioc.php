<?php
/**
 * Ioc контейнер системы
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 2/12/2018
 * Time: 10:04 PM
 */

namespace App\Ioc;


use App\Helpers\SingletonTrait;

class Ioc implements IocInterface
{
    use SingletonTrait;

    /** @var array $bindings */
    protected static $bindings = array();

    /**
     * Создает инстанс класса с переданными параметрами
     *
     * @param string $ioc_key
     * @param mixed ...$parameter
     * @return mixed
     * @throws IocException
     */
    public function create(string $ioc_key, ... $parameter)
    {
        //ищем в биндингах
        $found = array_key_exists($ioc_key, self::$bindings);

        //если не нашли - бросаем исключение
        if ($found === false) {
            throw new IocException('No bindings found for provided "'.$ioc_key.'" key!');
        }

        $subject = self::$bindings[$ioc_key];

        $parameters_qty = count($parameter);

        //если это функция
        if (is_callable($subject)) {
            if ($parameters_qty == 0) {
                return $subject();
            }

            if ($parameters_qty > 0) {
                return $subject(... $parameter);
            }
        }

        //иначе создадим экземпляр и вернем в качестве ответа
        $instance = null;
        if ($parameters_qty >= 1) {
            $instance = new $subject(... $parameter);
        } else {
            $instance = new $subject();
        }

        return $instance;
    }

    /**
     * Создает привязку - интерфейс класса к имени класса или
     * функции
     *
     * @param string $ioc_key
     * @param mixed $bind_subject
     * @return IocInterface
     * @throws IocException
     */
    public function bind(string $ioc_key, $bind_subject) : IocInterface
    {
        //проверим эту связку в биндингах, если таковой нет, то запишем, иначе бросим исключение
        $needle_key = array_search($ioc_key, self::$bindings, true);

        if (!empty($needle_key)) {
            throw new IocException('Ioc already bound to this key!');
        }

        self::$bindings[$ioc_key] = $bind_subject;

        return $this;
    }
}
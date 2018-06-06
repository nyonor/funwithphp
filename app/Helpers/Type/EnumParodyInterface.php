<?php
/**
 * Интерфейс, который позволяет
 * хранить типизированные значения с целью передачи их в
 * качестве аргументов
 *
 * Created by PhpStorm.
 * User: cadistortion
 * Date: 5/29/18
 * Time: 11:23 AM
 */

namespace App\Helpers\Type;


interface EnumParodyInterface
{
    /**
     * Извлекает значение из экземпляра.
     * Данное значение например может быть установлено при помощи
     * конструктора класс, реализующего интерфейс.
     *
     * @return mixed
     */
    public function getValue();
}
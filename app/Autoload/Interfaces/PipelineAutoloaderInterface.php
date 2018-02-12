<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 2/9/2018
 * Time: 4:36 PM
 */

namespace App\Autoload\Interfaces;

interface PipelineAutoloaderInterface
{
    /**
     * todo описание интерфейса
     * PipelineAutoloaderInterface constructor.
     * @param array $classes массив вида ['НЕЙМСПЕЙС', 'ИМЯ_КЛАССА'], будет использован для require_once классов
     */
    public function __construct(array $classes);
}
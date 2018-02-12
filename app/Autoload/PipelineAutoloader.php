<?php
/**
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 2/9/2018
 * Time: 3:22 PM
 *
 * todo описание автозагрузчика
 */

namespace App\Autoload;
use App\Autoload\Interfaces\PipelineAutoloaderInterface;
use Exception;

/**
 * Class PipelineAutoloader
 * @package App\Autoload
 */
class PipelineAutoloader implements PipelineAutoloaderInterface
{
    /**
     * PipelineAutoloader constructor.
     * @param array $classes
     * @throws Exception todo под вопросом
     */
    public function __construct(array $classes)
    {
        throw new Exception('Не реализованный метод!');
    }
}
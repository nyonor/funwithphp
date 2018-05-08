<?php
/**
 * Система устроена таким образом, чтобы можно было настраивать алгоритм передачи запросов.
 * Представьте, что запрос от пользователя пролетает через трубу =) и внутри этой трубы встроены модули,
 * которые по сути представляют некий функционал системы... например таким образом можно встроить чтобы вначале запрос
 * проходил модуль Security на этапе которого можно будет проверить запрос по безопасности (застрипслешить кавычки)
 * например, далее можно поставить модуль роутинга, который будет вызывать нужный контроллер и экшен, далее это запрос
 * можно перекинуть еще куда... короче это такая идея... посмотрим как оно пойдет...
 * Функционал для управления модулями в потоке обработки запроса (пайп)
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 2/22/2018
 * Time: 7:53 PM
 */

namespace App\Pipeline;


use App\Modules\ModuleArgumentInterface;
use App\Modules\ModuleInterface;

interface PipelineInterface
{
    /**
     * Регистрирует модуль в пайпе
     * @param ModuleInterface $module
     * @return $this
     */
    public function registerModule(ModuleInterface $module);

    /**
     * Запускает обработку запроса через все зарегистрированные модули
     * @param ModuleArgumentInterface $module_argument
     * @return void
     */
    public function go(ModuleArgumentInterface $module_argument);
}
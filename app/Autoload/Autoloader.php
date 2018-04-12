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
use const App\Config\APP_DIR;
use Exception;

/**
 * Class Autoloader
 * @package app\Autoload
 */
class Autoloader implements AutoloaderInterface
{

    /**
     * @var array [НЕЙМСПЕЙС => БАЗОВАЯ_ДИРЕКТОРИЯ] - конфиг для автозагрузчика
     */
    protected $requireArray;

    /**
     * Autoloader constructor.
     * @param array $require_array
     */
    public function __construct(array $require_array)
    {
        try {
            $this->requireArray = $require_array;
        } catch (Exception $e) {
            //todo логировать ошибки? чем? решить вопрос!
            return; //не кидаем ошибок, просто передаем управление другому автозагрузчику (если он есть)
        }
    }

    /**
     * Метод который непосредственно загружает запрошенный класс...
     * произведет поиск по связке неймспейс-базовая_директория, которые переданы в массиве $requireArray
     * (см. конструктор)
     * @param string $class - имя класса для загрузки вида [<НЕЙМСПЕЙС>\ИМЯ_КЛАССА]
     * @return mixed
     */
    public function loadClass($class)
    {
        // TODO: Implement loadClass() method.

        $posOfLastSlash = strrpos($class, '\\');
        $namespace = substr($class,0, $posOfLastSlash);
        $class_name = substr($class, $posOfLastSlash + 1, strlen($class));

        $path_to_file = $this->requireArray[$namespace];

        if ($path_to_file == null) {
            return false;
        }

        $required_file = str_replace('\\', '/', APP_DIR . $path_to_file . '/' . $class_name . '.php');

        if (file_exists($required_file) == false){
            return false;
        }

        require_once $required_file;

        return $required_file;
    }

    /**
     * Регистрирует метод "loadClass" класса имплементирующего интерфейс в кач-ве автозагрузчика через
     * spl_autoload_register
     * @return void
     */
    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }
}
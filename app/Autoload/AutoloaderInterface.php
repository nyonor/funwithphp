<?php
/**
 * Интерфейс автолоадера системы.
 * Класс, который реализует это интерфейс должен быть подключен первым в index.php!
 *
 * Created by PhpStorm.
 * User: NyoNor
 * Date: 2/9/2018
 * Time: 4:36 PM
 */

namespace App\Autoload;

interface AutoloaderInterface
{
    /**
     * В качестве аргумента передается массив-связка: Неймспейс -> Директория
     * AutoloaderInterface constructor.
     * @param array $requireArray массив вида ['НЕЙМСПЕЙС', 'ИМЯ_КЛАССА'], будет использован для require_once классов
     */
    public function __construct(array $requireArray);

    /**
     * Метод который непосредственно загружает запрошенный класс...
     * произведет поиск по связке неймспейс-базовая_директория, которые переданы в массиве $requireArray
     * (см. конструктор)
     * @param string $class - имя класса для загрузки вида [<НЕЙМСПЕЙС>\ИМЯ_КЛАССА]
     * @return mixed
     */
    public function loadClass($class);

    /**
     * Регистрирует метод "loadClass" класса имплементирующего интерфейс в кач-ве автозагрузчика через
     * spl_autoload_register
     * @return void
     */
    public function register();
}
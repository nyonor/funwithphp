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


use App\DAL\DbConnectionInterface;
use App\DAL\Mysql\MysqlPdoDbConnection;
use App\DAL\Mysql\MysqlPdoDbConnectionInterface;
use App\Helpers\Path;
use App\Helpers\PathInterface;
use App\Helpers\SingletonTrait;
use App\Modules\ModuleArgument;
use App\Modules\ModuleArgumentInterface;
use App\Modules\Mvc\Controller\ActionResult\ActionResultFactory;
use App\Modules\Mvc\Controller\ActionResult\ActionResultFactoryInterface;
use App\Modules\Mvc\Controller\ActionResult\ViewResult;
use App\Modules\Mvc\Controller\ActionResult\ViewResultInterface;
use App\Modules\Mvc\Controller\MvcControllerFactory;
use App\Modules\Mvc\Controller\MvcControllerFactoryInterface;
use App\Modules\Mvc\MvcModule;
use App\Modules\Mvc\MvcModuleInterface;
use App\Http\Request;
use App\Http\RequestInterface;
use App\Http\Response;
use App\Http\ResponseInterface;
use App\Modules\Mvc\Routing\Route;
use App\Modules\Mvc\Routing\RouteArgument;
use App\Modules\Mvc\Routing\RouteArgumentInterface;
use App\Modules\Mvc\Routing\RouteInterface;
use App\Modules\Mvc\Routing\Routing;
use App\Modules\Mvc\Routing\RoutingInterface;
use App\Modules\Mvc\View\Render\TwigRender;
use App\Modules\Mvc\View\Render\ViewRenderInterface;
use App\Pipeline\Pipeline;
use App\Pipeline\ModuleArgumentHandler;
use App\Pipeline\ModuleArgumentHandlerInterface;
use App\Pipeline\PipelineInterface;
use App\Pipeline\ResponseHandler;
use App\Pipeline\ResponseHandlerInterface;
use Segments\Nyo\Services\Authorization\AuthorizationService;
use Segments\Nyo\Services\Authorization\AuthorizationServiceInterface;
use Segments\Nyo\Services\Authorization\Vk\VkAuthorizationService;
use Segments\Nyo\Services\Authorization\Vk\VkAuthorizationServiceInterface;
use Segments\Nyo\Services\Registration\UserRegistrationService;
use Segments\Nyo\Services\Registration\UserRegistrationServiceInterface;

class Ioc implements IocInterface
{
    use SingletonTrait;

    //todo видимо это должно быть вынесено в конфиг?
    /*protected static $autoloadBinds = [
        ActionResultFactoryInterface::class => ActionResultFactory::class,
        ModuleArgumentHandlerInterface::class => ModuleArgumentHandler::class,
        ModuleArgumentInterface::class => ModuleArgument::class,
        MvcControllerFactoryInterface::class => MvcControllerFactory::class,
        MvcModuleInterface::class => MvcModule::class,
        PathInterface::class => Path::class,
        PipelineInterface::class => Pipeline::class,
        RoutingInterface::class => Routing::class,
        RouteInterface::class => Route::class,
        RouteArgumentInterface::class => RouteArgument::class,
        RequestInterface::class => Request::class,
        ResponseInterface::class => Response::class,
        ResponseHandlerInterface::class => ResponseHandler::class,
        ViewRenderInterface::class => TwigRender::class,
        ViewResultInterface::class => ViewResult::class,
        MysqlPdoDbConnectionInterface::class => MysqlPdoDbConnection::class,

        AuthorizationServiceInterface::class => AuthorizationService::class,
        VkAuthorizationServiceInterface::class => VkAuthorizationService::class,
        UserRegistrationServiceInterface::class => UserRegistrationService::class
    ];*/

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
            throw new IocException('No bindings found for provided key!');
        }

        //иначе создадим инстанс и вернем в качестве ответа
        $instance = null;
        if (count($parameter) > 1) {
            $instance = new self::$bindings[$ioc_key](... $parameter);
        } else if (count($parameter) == 1){
            $instance = new self::$bindings[$ioc_key]($parameter);
        } else {
            $instance = new self::$bindings[$ioc_key]();
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
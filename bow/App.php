<?php
namespace Bow;

use Slim\Container;
use InvalidArgumentException;
use Interop\Container\ContainerInterface;

class App
{

    /**
     * Container
     *
     * @var ContainerInterface
     */
    private $container;

    /********************************************************************************
     * Constructor
     *******************************************************************************/

    /**
     * Create new application
     *
     * @param ContainerInterface|array $container Either a ContainerInterface or an associative array of app settings
     * @throws InvalidArgumentException when no container is provided that implements ContainerInterface
     */
    public function __construct($container = [])
    {
        if (is_array($container)) {
            $container = new Container($container);
        }
        if (!$container instanceof ContainerInterface) {
            throw new InvalidArgumentException('Expected a ContainerInterface');
        }
        $this->container = $container;
    }

    /**
     * Enable access to the DI container by consumers of $app
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function registerWe7Service($dirPath)
    {
        $plugins = $this->collectPlugins($dirPath);

        if ( count($plugins) > 0 ) {
            foreach ($plugins as $key => $value) {
                $this->registerPlugins($value[0] , $value[1]);
            }
        }
    }

    public function collectPlugins($dirPath)
    {
        $plugins = [];

        if (!is_dir($dirPath)) {
            return $plugins;
        }

        $it = new \RegexIterator(
            new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dirPath, \RecursiveDirectoryIterator::FOLLOW_SYMLINKS)
        )
            , '/^.+\.php$/i'
            , \RecursiveRegexIterator::GET_MATCH
        );
        $it->setMaxDepth(6);
        $it->rewind();

        while ($it->valid()) {
            if (($it->getDepth() > 1) && $it->isFile()/* && (strtolower($it->getFilename()) == "plugin.php") */) {
                // $filePath = dirname($it->getPathname());
                // var_dump($filePath);
                // var_dump($it->getPathname());
                // $pluginName = basename($filePath);
                // $vendorName = basename(dirname($filePath));
                // $plugins[$vendorName][$pluginName] = $filePath;
                $plugins[] = [
                \Illuminate\Support\Str::substr($it->getPathname() , strlen($dirPath)),
                $it->getPathname(),
                ];
            }

            $it->next();
        }

        return $plugins;
    }

    public function registerPlugins($shortPath , $fullPath)
    {
        include $fullPath;
        $container = $this->getContainer();

        $identifier = 'do';
        $class = '\Bow';

        $arr_short_path = explode('/', $shortPath);

        foreach ($arr_short_path as $key => $value) {

            if (!$value) {
                continue;
            }

            if ( strstr($value, '.php') ) {
                $value = str_replace('.php', '', $value);
            }

            $identifier .= '.' . \Illuminate\Support\Str::lower($value);
            $class .= '\\' . \Illuminate\Support\Str::ucfirst($value);
        }

        if ( ! isset($container[$identifier]) ) {
            $container[$identifier] = function ($container) use ($class)
            {
                return new $class($container);
            };
        }

    }

    /**
     * Calling a non-existant method on App checks to see if there's an item
     * in the container that is callable and if so, calls it.
     *
     * @param  string $method
     * @param  array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if ($this->container->has($method)) {
            $obj = $this->container->get($method);
            if (is_callable($obj)) {
                return call_user_func_array($obj, $args);
            }
        }

        throw new \BadMethodCallException("Method $method is not a valid method");
    }
}

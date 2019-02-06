<?php
namespace edsonmedina\php_testability;

class Dictionary
{
    private $phpInternalFunctions   = [];
    private $unsafeForInstantiation = [];

    public function __construct()
    {
        // TODO remove work from constructor
        $list = get_defined_functions();
        $this->phpInternalFunctions = array_fill_keys($list['internal'], true);

        $this->unsafeForInstantiation = array_map('strtolower', [
            'SplFileInfo', 'DirectoryIterator', 'FilesystemIterator',
            'GlobIterator', 'SplFileObject', 'SplTempFileObject',
            'Reflection', 'ReflectionFunctionAbstract', 'ReflectionFunction',
            'ReflectionParameter', 'ReflectionMethod', 'ReflectionClass',
            'ReflectionObject', 'ReflectionProperty', 'ReflectionExtension',
            'ReflectionZendExtension', 'ZipArchive', 'PDO', 'XMLReader',
            'finfo', 'Phar', 'SoapClient', 'SoapServer', 'DOMDocument'
        ]);
    }

    /**
     * Is this a php internal function?
     * @param string $functionName
     * @return bool
     */
    public function isInternalFunction($functionName)
    {
        return isset($this->phpInternalFunctions[$functionName]);
    }

    /**
     * Is this a php internal class?
     * @param string $className
     * @return bool
     */
    public function isClassSafeForInstantiation($className)
    {
        $className = strtolower($className);

        // does it have namespaces?
        if (false !== strpos($className, '\\')) {
            return false;
        }
        if ($className === 'parent') {
            return true;
        }
        // check if it's in the black list
        if (in_array($className, $this->unsafeForInstantiation)) {
            return false;
        }
        // check if it's a php native class
        elseif (in_array($className, array_map('strtolower', get_declared_classes()))) {
            return true;
        }

        return false;
    }
}

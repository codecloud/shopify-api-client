<?php
namespace CodeCloud\ShopifyApiClient\CodeGeneration;

use Memio\Memio\Config\Build;
use Memio\Model\Argument;
use Memio\Model\File;
use Memio\Model\Method;
use Memio\Model\Object;
use Memio\PrettyPrinter\PrettyPrinter;
use Symfony\Component\Yaml\Parser;

class EndpointGenerator
{
    /**
     * @var Parser
     */
    private $yamlParser;

    /**
     * @param Parser $yamlParser
     */
    public function __construct(Parser $yamlParser)
    {
        $this->yamlParser = $yamlParser;
    }

    /**
     * @param string $endpointConfigDir
     * @param string $outputDir
     * @throws \Exception
     */
    public function generateModels($endpointConfigDir, $outputDir)
    {
        $this->prepareOutputDir($outputDir);

        foreach ($this->getConfigs($endpointConfigDir) as $config) {
            $code = $this->generatePhpCodeFromConfig($config);
            $this->write($outputDir . DIRECTORY_SEPARATOR . $config['name'] . '.php', $code);
        }
    }

    /**
     * @param string $endpointConfigDir
     * @return \Generator
     */
    private function getConfigs($endpointConfigDir)
    {
        /** @var \SplFileInfo $file */
        foreach ($this->getConfigFiles($endpointConfigDir) as $file) {
            $configName = $file->getBasename('.yaml');
            $parsed     = $this->yamlParser->parse(file_get_contents($file->getRealPath()), true, true);

            yield [
                'name'   => $configName,
                'config' => $parsed
            ];
        }
    }

    /**
     * @param string $endpointConfigDir
     * @return \Generator
     */
    private function getConfigFiles($endpointConfigDir)
    {
        $dir = new \DirectoryIterator($endpointConfigDir);

        foreach ($dir as $entry) {
            if ($entry->getExtension() != 'yaml') {
                continue;
            }

            yield $entry;
        }
    }

    /**
     * @param string $outputDir
     * @return void
     * @throws \Exception
     */
    private function prepareOutputDir($outputDir)
    {
        if (! file_exists($outputDir)) {
            mkdir($outputDir);
        }

        if (! is_writable($outputDir)) {
            throw new \Exception($outputDir . ' is not writable');
        }
    }

    /**
     * @param string $content
     * @param string $target
     */
    private function write($target, $content)
    {
        file_put_contents($target, $content);
    }

    /**
     * @param array $config
     */
    private function generatePhpCodeFromConfig(array $config)
    {
        $className = $config['name'];
        $namespace = 'Codecloud\\ShopifyApiClient\\Endpoint';

        $file = File::make('blah');

        $object = Object::make($namespace . '\\' . $className);
        $object->extend(Object::make($namespace . '\\Endpoint'));

        foreach ($config['config'] as $methodName => $methodConfig) {
            $urlParams = $requiredParams = [];

            $method = new Method($methodName);
            $methodBody = '';

            if (! empty($methodConfig['url_params'])) {
                foreach ($methodConfig['url_params'] as $paramName => $paramConfig) {
                    $type = is_array($paramConfig) ? $paramConfig['type'] : $paramConfig;
                    $arg = new Argument($type, $paramName);
                    $method->addArgument($arg);
                    $urlParams[] = '$' . $paramName;
                }
            }

            $kwArgs = false;


            if (! empty($methodConfig['allow'])) {
                foreach ($methodConfig['allow'] as $paramName => $paramConfig) {
                    if (! empty($paramConfig['required'])) {
                        if (is_array($paramConfig)) {
                            $type = $paramConfig['type'];
                        } else {
                            $type = $paramConfig;
                        }

                        if ($type == 'currency') {
                            $type = 'string';
                        }

                        $argument = new Argument($type, $paramName);
                        $method->addArgument($argument);
                        $requiredParams[] = '$' . $paramName;
                    } else {
                        $kwArgs = true;
                    }
                }
            }

            $kwArgsStmt = $requiredParamsStmt = '';

            if ($kwArgs) {
                $arg = new Argument('array', 'params');
                $arg->setDefaultValue([]);
                $method->addArgument($arg);
                $kwArgsStmt = ', $params';
            }

            if ($requiredParams) {
                $methodBody .= $this->normaliseMethodBody('$params = array_merge($params, compact(' . implode(', ', $requiredParams) .  '));');
            }

            if ($urlParams) {
                $methodBody .= $this->normaliseMethodBody('$url = $this->getMethod(\'' . $methodName . '\')->constructUrlWithParams(compact(' . implode(', ', $urlParams) . '));');
                $methodBody .= $this->normaliseMethodBody('$response = $this->api->' . $methodConfig['type'] . '($url' . $kwArgsStmt . ');');
            } else {
                $methodBody .= $this->normaliseMethodBody('$response = $this->api->' . $methodConfig['type'] . '($this->getMethod(\'' . $methodName . '\')->getUrl()' . $kwArgsStmt . ');');
            }

            if (! empty($methodConfig['returns'])) {
                $methodBody .= $this->normaliseMethodBody('return $response->get(\'' . $methodConfig['returns'] . '\');');
            } else {
                $methodBody .= $this->normaliseMethodBody('return $response;');
            }

            $method->setBody(rtrim($methodBody));

            $object->addMethod($method);
        }

        $file->setStructure($object);

        return Build::prettyPrinter()->generateCode($file);
    }

    /**
     * @param string $body
     * @return string
     */
    private function normaliseMethodBody($body)
    {
        return str_repeat(' ', 8) . $body . PHP_EOL;
    }
}
<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Console\Application;

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__));
$loader->load(__DIR__ . '/services.yml');
$loader->load(__DIR__ . '/parameters.yml');
if (defined('ENV_TEST') && ENV_TEST) {
    $loader->load(__DIR__ . '/services_test.yml');
    $loader->load(__DIR__ . '/parameters_test.yml');
}
$application = new Application();
$application->add($container->get('run_shift_command'));
$statusCode = $application->run();

exit($statusCode);
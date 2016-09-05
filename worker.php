<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Console\Application;

$container = new ContainerBuilder();
$configDir = __DIR__ . '/config/';
$loader = new YamlFileLoader($container, new FileLocator($configDir));
$loader->load('services.yml');
$loader->load('parameters.yml');
if (defined('ENV_TEST') && ENV_TEST) {
    $loader->load('services_test.yml');
    $loader->load('parameters_test.yml');
}
$application = new Application();
$application->add($container->get('app.command.start_worker'));
$statusCode = $application->run();

exit($statusCode);
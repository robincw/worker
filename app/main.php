<?php
require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Console\Application;

$container = new ContainerBuilder();
$configDir = __DIR__ . '/config/';
$loader = new YamlFileLoader($container, new FileLocator($configDir));
$loader->load('services.yml');
$loader->load('parameters.yml');
if (getenv('ENV_TEST')==1) {
	echo "TEST ENVIRONMENT" . PHP_EOL;
    if(file_exists($configDir . 'services_test.yml')) $loader->load('services_test.yml');
    if(file_exists($configDir . 'parameters_test.yml')) $loader->load('parameters_test.yml');
}
$application = new Application();
$application->add($container->get('app.command.test_the_queue'));
$application->add($container->get('app.command.start_worker'));
$statusCode = $application->run();

exit($statusCode);
<?php


namespace AppBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AppExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('angularjs.yml');
    }


    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        // Add angularjs in Twig globals parameters
        $twig = Yaml::parse(__DIR__ . '/../Resources/config/angularjs.yml');
        $twig = array('globals' => $twig['parameters']);
        $container->prependExtensionConfig('twig', $twig);
    }
}

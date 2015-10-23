<?php

namespace Rth\MotorbikeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rth_motorbike');

        $rootNode
                ->children()
                    ->arrayNode('general')
                        ->children()
                            ->scalarNode('upload_path')->end()
                            ->scalarNode('upload_directory')->end()
                            ->integerNode('image_tumbnail_width')->end()
                            ->integerNode('image_tumbnail_height')->end()
                        ->end()
                    ->end() // general
                    ->arrayNode('default')
                        ->children()
                            ->integerNode('motorbikes_per_page')->end()
                        ->end()
                    ->end() // default
                ->end()
        ;

        return $treeBuilder;
    }

}

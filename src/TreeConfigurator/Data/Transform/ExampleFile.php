<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Transform;

class ExampleFile
{

    public static function create(array $data) : array
    {
        $trees = ExampleTrees::create($data['trees']);
        $treeDecorations = ExampleTreeDecoration::create($data['tree-decorations']);

        return [
            'trees' => $trees,
            'tree-decorations' => $treeDecorations,
        ];
    }
}


<?php

namespace App\View\Widget;

use Cake\View\Form\ContextInterface;
use Cake\View\Widget\WidgetInterface;
use Cake\Routing\Router;

class TextareaEditorWidget implements WidgetInterface
{

    protected $_templates;

    public function __construct($templates)
    {
        $this->_templates = $templates;
    }

    public function render(array $data, ContextInterface $context)
    {
        $data += [
            'name' => '',
            'val'  => '',
        ];

        return $this->_templates->format(
            'textarea-editor',
            [
                'name'  => $data['name'],
                'value' => $data['val'],
                'id'    => $data['id'],
                'attrs' => $this->_templates->formatAttributes(
                    $data,
                    [
                        'name',
                        'source',
                        'val',
                        'id',
                    ]
                ),
            ]
        );
    }

    public function secureFields(array $data)
    {
        return [$data['name']];
    }
}
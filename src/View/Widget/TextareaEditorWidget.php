<?php

namespace App\View\Widget;

use Cake\View\Form\ContextInterface;
use Cake\View\Widget\WidgetInterface;

class TextareaEditorWidget implements WidgetInterface
{

    protected $_templates;

    public function __construct($templates)
    {
        $this->_templates = $templates;
    }

    public function render(array $data, ContextInterface $context): string
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

    /**
     * @param array $data
     *
     * @return array|string[]
     */
    public function secureFields(array $data): array
    {
        return [$data['name']];
    }
}

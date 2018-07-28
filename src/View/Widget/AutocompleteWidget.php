<?php
namespace App\View\Widget;

use Cake\View\Form\ContextInterface;
use Cake\View\Widget\WidgetInterface;
use Cake\Routing\Router;

class AutocompleteWidget implements WidgetInterface
{

    protected $_templates;

    public function __construct($templates)
    {
        $this->_templates = $templates;
    }

    public function render(array $data, ContextInterface $context)
    {
        $data += [
            'name'   => '',
            'source' => [
                'controller' => '',
                'action' => ''
            ],
            'val' => '',
        ];
        return $this->_templates->format('autocomplete', [
            'name'   => $data['name'],
            'val'    => $data['val'],
            'source' => Router::url($data['source']),
            'attrs'  => $this->_templates->formatAttributes($data, ['name', 'source', 'value'])
        ]);
    }

    public function secureFields(array $data)
    {
        return [$data['name']];
    }
}
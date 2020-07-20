<?php
namespace App\View\Widget;

use Cake\View\Form\ContextInterface;
use Cake\View\Widget\WidgetInterface;
use Cake\Routing\Router;

class AutocompleteToTableWidget implements WidgetInterface
{
    private const ATTR_ATTRIBUTES       = 'attrs';
    public const ATTR_CONDITIONALS      = 'conditionals';
    public const ATTR_ELEMENT_NAME      = 'name';
    public const ATTR_EXCLUDES          = 'excludes';
    /** @var string - Array key for the table headings */
    public const ATTR_HEADING           = 'heading';
    public const ATTR_SOURCE            = 'source';
    public const ATTR_SOURCE_ACTION     = 'action';
    public const ATTR_SOURCE_CONTROLLER = 'controller';
    public const ATTR_VALUE             = 'val';

    protected $_templates;

    public function __construct($templates)
    {
        $this->_templates = $templates;
    }

    public function render(array $data, ContextInterface $context)
    {
        $data += [
            self::ATTR_ELEMENT_NAME => '',
            self::ATTR_SOURCE       => [
                self::ATTR_SOURCE_ACTION     => '',
                self::ATTR_SOURCE_CONTROLLER => '',
            ],
            self::ATTR_VALUE        => [],
            self::ATTR_CONDITIONALS => [],
            self::ATTR_EXCLUDES     => [],
        ];


        $excludes = [];
        foreach ($data[self::ATTR_EXCLUDES] as $key => $value) {
            $excludes[] = [
                'key'   => $key,
                'value' => $value,
            ];
            unset ($key, $value);
        }
        $data[self::ATTR_EXCLUDES] = json_encode($excludes);

        $values = [];
        foreach ($data[self::ATTR_VALUE] as $key => $value) {
            $values[] = [
                'label' => $value,
                'value' => $key,
            ];
            unset($key, $value);
        }
        $data[self::ATTR_VALUE] = json_encode($values);
        $return = $this->_templates->format('autocomplete-to-table', [
            self::ATTR_ELEMENT_NAME => $data[self::ATTR_ELEMENT_NAME],
            self::ATTR_VALUE        => $data[self::ATTR_VALUE],
            self::ATTR_SOURCE       => Router::url($data[self::ATTR_SOURCE]),
            self::ATTR_HEADING      => ucfirst($data[self::ATTR_HEADING]),
            self::ATTR_CONDITIONALS => implode(',', $data[self::ATTR_CONDITIONALS]),
            self::ATTR_EXCLUDES     => $data[self::ATTR_EXCLUDES],
            self::ATTR_ATTRIBUTES   => $this->_templates->formatAttributes(
                $data,
                [
                    self::ATTR_ELEMENT_NAME,
                    self::ATTR_SOURCE,
                    self::ATTR_EXCLUDES,
                    self::ATTR_HEADING,
                    self::ATTR_CONDITIONALS,
                    self::ATTR_VALUE,
                ]
            ),
        ]);

        return $return;
    }

    public function secureFields(array $data)
    {
        return [$data[self::ATTR_ELEMENT_NAME]];
    }
}
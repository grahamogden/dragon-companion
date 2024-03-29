<?php

return [
    // Used for button elements in button().
    'button'                => '<button{{attrs}}>{{text}}</button>',
    // Used for checkboxes in checkbox() and multiCheckbox().
    'checkbox'              => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
    // Input group wrapper for checkboxes created via control().
    'checkboxFormGroup'     => '{{label}}',
    // Wrapper container for checkboxes.
    'checkboxWrapper'       => '<div class="checkbox">{{label}}</div>',
    // Widget ordering for date/time/datetime pickers.
    'dateWidget'            => '{{year}}{{month}}{{day}}{{hour}}{{minute}}{{second}}{{meridian}}',
    // Error message wrapper elements.
    'error'                 => '<div class="col-12 error-message alert alert-danger">{{content}}</div>',
    // Container for error items.
    'errorList'             => '<ul>{{content}}</ul>',
    // Error item wrapper.
    'errorItem'             => '<li>{{text}}</li>',
    // File input used by file().
    'file'                  => '<input type="file" name="{{name}}"{{attrs}}>',
    // Fieldset element used by allControls().
    'fieldset'              => '<fieldset{{attrs}}>{{content}}</fieldset>',
    // Open tag used by create().
    'formStart'             => '<form{{attrs}}>',
    // Close tag used by end().
    'formEnd'               => '</form>',
    // General grouping container for control(). Defines input/label ordering.
    'formGroup'             => '<div class="col-12 col-md-12 col-lg-12">{{label}}</div><div class="col-12 col-md-12 col-lg-6">{{input}}</div>',
    // Wrapper content used to hide other content.
    'hiddenBlock'           => '<div style="display:none;">{{content}}</div>',
    // Generic input element.
    'input'                 => '<input type="{{type}}" name="{{name}}" autocomplete="off"{{attrs}}/>',
    // Submit input element.
    'inputSubmit'           => '<input type="{{type}}"{{attrs}}/>',
    // Container element used by control().
    'inputContainer'        => '<div class="input row form-group {{type}}{{required}}">{{content}}</div>',
    // Container element used by control() when a field has an error.
    'inputContainerError'   => '<div class="input row form-group {{type}}{{required}} error">{{content}}{{error}}</div>',
    // Label element when inputs are not nested inside the label.
    'label'                 => '<label{{attrs}}>{{text}}</label>',
    // Label element used for radio and multi-checkbox inputs.
    'nestingLabel'          => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>',
    // Legends created by allControls()
    'legend'                => '<legend>{{text}}</legend>',
    // Multi-Checkbox input set title element.
    'multicheckboxTitle'    => '<legend>{{text}}</legend>',
    // Multi-Checkbox wrapping container.
    'multicheckboxWrapper'  => '<fieldset{{attrs}}>{{content}}</fieldset>',
    // Option element used in select pickers.
    'option'                => '<option value="{{value}}"{{attrs}}>{{text}}</option>',
    // Option group element used in select pickers.
    'optgroup'              => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>',
    // Select element,
    'select'                => '<select name="{{name}}"{{attrs}}>{{content}}</select>',
    // Multi-select element,
    'selectMultiple'        => '<select name="{{name}}[]" multiple="multiple"{{attrs}}>{{content}}</select>',
    // Radio input element,
    'radio'                 => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
    // Wrapping container for radio input/label,
    'radioWrapper'          => '{{label}}',
    // Textarea input element,
    'textarea'              => '<div class="input row ml-0 mr-0"><textarea name="{{name}}"{{attrs}}>{{value}}</textarea></div>',
    // Container for submit buttons.
    'submitContainer'       => '{{content}}',
    //'<div class="submit">{{content}}</div>',
    /********************
     * CUSTOM TEMPLATES *
     ********************/
    // Have to stupidly hack value="{{val}}" because the widget refuses to add the "value" attribute and will instead create "val"
    'autocomplete'          => '<div class="autocomplete-container input">
            <input type="text" name="{{name}}" id="autocomplete-{{name}}" value="{{val}}" {{attrs}} {{excludes}} data-source="{{source}}" />
            <div class="autocomplete-results" id="results-{{name}}"></div>
        </div>',
    'autocomplete-to-table' => '<div class="autocomplete-table-container input">
            <table id="autocomplete-{{name}}-table" class="table table-hover autocomplete-table">
                <thead>
                    <tr><th>{{heading}}</th><th>Actions</th></tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr class="autocomplete-row">
                        <td colspan="2">
                            <div class="autocomplete-container input">
                                <input type="text" name="{{name}}-field" id="autocomplete-{{name}}-field" {{attrs}} data-excludes=\'{{excludes}}\' data-source="{{source}}" data-conditionals="{{conditionals}}" data-autocomplete-for="{{name}}" />
                                <div class="autocomplete-results" id="results-autocomplete-{{name}}-field"></div>
                                <input type="hidden" name="{{name}}" id="{{name}}" class="autocomplete-data" value=\'{{val}}\' />
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>',
    'textarea-editor'       => '
        <div class="textarea-editor">
            <textarea id="textarea-editor-input-{{name}}" name="{{name}}" class="textarea-editor-content {{class}}" {{attrs}}>{{value}}</textarea>
        </div>',
    // 'textarea-editor'  => '
    // <div id="textarea-editor-{{name}}" class="textarea-editor" data-name="{{name}}" data-id="{{id}}">
    //     <div class="textarea-editor-toolbar sticky-element">
    //         <i class="icon icon-undo" title="Undo"></i><i class="icon icon-redo" title="Redo"></i><i class="icon icon-bold" title="Bold"></i><i class="icon icon-italic" title="Italic"></i><i class="icon icon-underline" title="Underline"></i><i class="icon icon-strikethrough" title="Strikethrough"></i><i class="icon icon-ol" title="Numbered list"></i><i class="icon icon-ul" title="Dotted list"></i><i class="icon icon-unindent" title="Delete indentation"></i><i class="icon icon-indent" title="Add indentation"></i><i class="icon icon-hr" title="Add horizontal line rule"></i><i class="icon icon-table" title="Add table"></i><i class="icon icon-add-row"></i><i class="icon icon-add-column"></i><i class="icon icon-restore" title="Open autosave"></i><i class="icon icon-full-screen" title="Full screen"></i><i class="icon icon-auto-height" title="Auto height"></i>
    //         <a class="toggle-toolbar"></a>
    //     </div>
    //     <div contenteditable="true" id="textarea-editor-content-{{name}}" class="textarea-editor-content" data-for="textarea-editor-input-{{name}}" {{attrs}}></div>
    //     <input id="textarea-editor-input-{{name}}" name="{{name}}" class="textarea-editor-value" type="hidden" value="{{value}}" />
    // </div>',
];

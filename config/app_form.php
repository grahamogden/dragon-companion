<?php

// Have to stupidly hack value="{{val}}" because the widget refuses to add the "value" attribute and will instead create "val"
return [
    'autocomplete' => '<div class="autocomplete-container"><input type="text" name="{{name}}" id="autocomplete-{{name}}" value="{{val}}" {{attrs}} /><div class="autocomplete-results" id="results-{{name}}"></div><input type="hidden" class="autocomplete-template" /></div>
    <script>
        $( function() {
            function split( val ) {
                return val.split( /,\s*/ );
            }
            function extractLast( term ) {
                return split( term ).pop();
            }
         
            $( "#autocomplete-{{name}}" )
                // dont navigate away from the field on tab when selecting an item
                .on( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    appendTo: "#results-{{name}}",
                    minLength: 3,
                    position: {
                        my: "center (bottom - 2px)",
                        of: "autocomplete-{{name}}"
                    },
                    source: function( request, response ) {
                        $.getJSON( "{{source}}", {
                            term: extractLast( request.term )
                        }, response );
                        $(".ui-helper-hidden-accessible").remove();
                    },
                    search: function() {
                        // custom minLength - because using the other one does not always work!
                        // It should be noted this causes a bug whereby when deleting less than
                        // 3 characters results in the autocomplete staying visible
                        var term = extractLast( this.value );
                        if ( term.length < 3 ) {
                            return false;
                        }
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        var terms = split( this.value );
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push( ui.item.value );
                        // add placeholder to get the comma-and-space at the end
                        terms.push( "" );
                        this.value = terms.join( ", " );
                        return false;
                    }
            });
        } );
    </script>',
    // 'textareaeditor' => '<textarea id="{{id}}" class="textarea-editor {{class}}" {{attrs}}>{{value}}</textarea>',
    'textareaeditor' => '
    <div id="textarea-editor-{{name}}" class="textarea-editor" data-name="{{name}}" data-id="{{id}}">
        <div class="textarea-editor-toolbar sticky-element">
            <i class="icon icon-undo" title="Undo"></i><i class="icon icon-redo" title="Redo"></i><i class="icon icon-bold" title="Bold"></i><i class="icon icon-italic" title="Italic"></i><i class="icon icon-underline" title="Underline"></i><i class="icon icon-strikethrough" title="Strikethrough"></i><i class="icon icon-ol" title="Numbered list"></i><i class="icon icon-ul" title="Dotted list"></i><i class="icon icon-unindent" title="Delete indentation"></i><i class="icon icon-indent" title="Add indentation"></i><i class="icon icon-hr" title="Add horizontal line rule"></i><i class="icon icon-table" title="Add table"></i><i class="icon icon-restore" title="Open autosave"></i><i class="icon icon-full-screen" title="Full screen"></i><i class="icon icon-auto-height" title="Auto height"></i>
            <a class="toggle-toolbar"></a>
        </div>
        <div contenteditable="true" id="textarea-editor-content-{{name}}" class="textarea-editor-content" data-for="textarea-editor-input-{{name}}" {{attrs}}></div>
        <input id="textarea-editor-input-{{name}}" name="{{name}}" class="textarea-editor-value" type="hidden" value="{{value}}" />
    </div>',
];
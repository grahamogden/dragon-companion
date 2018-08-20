<?php

// Have to stupidly hack value="{{val}}" because the widget refuses to add the "value" attribute and will instead create "val"
return [
    'autocomplete' => '<div class="autocomplete-container"><input type="text" name="{{name}}" id="autocomplete-{{name}}" value="{{val}}" {{attrs}} /><div class="autocomplete-results" id="results-{{name}}"></div><input type="hidden" class="autocomplete-template" /></div>
    <script>
        // $("#autocomplete-{{name}}").autocomplete({
        //     source: "{{source}}",
        //     minLength: 3
        // });
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
    'textareaeditor' => '
    <div class="textarea-editor">
        <div class="textarea-editor-toolbar">
            <img class="icon icon-undo" title="Undo" onclick="formatDoc(\'undo\');"/><img class="icon icon-redo" title="Redo" onclick="formatDoc(\'redo\');"/><img class="icon icon-bold" title="Bold" onclick="formatDoc(\'bold\');"/><img class="icon icon-ital" title="Italic" onclick="formatDoc(\'italic\');"/><img class="icon icon-under" title="Underline" onclick="formatDoc(\'underline\');"/><img class="icon icon-strik" title="Strikethrough" onclick="formatDoc(\'strikeThrough\');"/><img class="icon icon-ol" title="Numbered list" onclick="formatDoc(\'insertorderedlist\');"/><img class="icon icon-ul" title="Dotted list" onclick="formatDoc(\'insertunorderedlist\');"/><img class="icon icon-unind" title="Delete indentation" onclick="formatDoc(\'outdent\');"/><img class="icon icon-inden" title="Add indentation" onclick="formatDoc(\'indent\');"/><img class="icon icon-hr" title="Add horizontal line rule" onclick="formatDoc(\'insertHorizontalRule\');"/><img class="icon icon-open" title="Open autosave" onclick="openAutoSave(\'{{name}}\');"/>
        </div>
        <div contenteditable="true" class="textarea-editor-content" data-for="input-textarea-editor-{{name}}" data-auto-save-name="{{name}}" {{attrs}}></div>
        <input id="input-textarea-editor-{{name}}" name="{{name}}" class="textarea-editor-value" type="hidden" value="{{value}}" />
    </div>',
];
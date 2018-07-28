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
];
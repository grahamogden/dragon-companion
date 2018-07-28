<?php

// Have to stupidly hack value="{{val}}" because the widget refuses to add the "value" attribute and will instead create "val"
return [
    'autocomplete' => '<input type="text" name="{{name}}" id="autocomplete-{{name}}" value="{{val}}" {{attrs}} /><div class="tags-container"></div><input type="hidden" class="autocomplete-template" />
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
                minLength: 3,
                source: function( request, response ) {
                    $.getJSON( "{{source}}", {
                        term: extractLast( request.term )
                    }, response );
                    $(".ui-helper-hidden-accessible").remove();
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
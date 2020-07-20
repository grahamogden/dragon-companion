const setCookie = function (key, value) {
    let expires = new Date();
    expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));
    // let path = /((http\:\/\/)[a-z0-9:]*)/gm.exec(window.location.href)[0];
    document.cookie = key + '=' + value + ';path=/;expires=' + expires.toUTCString();
};

const getCookie = function (key) {
    let keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
};

const removeAutocompleteItemFromTable = function ($, self, autocompleteFor, id) {
    let $autocomplete    = $('#' + autocompleteFor);
    let autocompleteJson = $($autocomplete).val();

    if (autocompleteJson === '' || typeof autocompleteJson === 'undefined') {
        autocompleteJson = [];
    }

    let autocompleteData = JSON.parse(autocompleteJson);

    $.each(autocompleteData, function (index, datum) {
        if (datum.value === id) {
            autocompleteData.splice(index, 1);
            return false;
        }
    });

    $($autocomplete).val(JSON.stringify(autocompleteData));

    $(self).closest('tr').remove();
};

jQuery(function ($) {

    $('.menu-button').click(function () {
        $(this).parent('.actions').toggleClass('open');
        // $(this).siblings('.menu').slideToggle(transitionTime);
    });

    $('#nav-menu-button').click(function () {
        $('header nav').toggleClass('open');
        $(this).toggleClass('open');
    });

    $('.show-more-content').each(function () {
        let height = parseInt($(this).css('height'));
        if (height >= 260) {
            $(this)
                .parent()
                .addClass('active')
                .append(
                    '<a class="show-more-link text-secondary"><span class="show">show</span><span class="hide">hide</span> more</a>'
                );
        }
    });

    $('.show-more-link').on('click', function () {
        $(this)
            .parent('.show-more-container')
            .toggleClass('open');
    });

    // setDarkMode(getCookie('darkMode'));

    $('#switch-dark-mode').on('change', function () {
        let isChecked = $(this).is(':checked');
        // console.log(isChecked);
        setDarkMode(isChecked);
    });

    /**
     * Splits a comma-separated string into an array
     * @param  string val - the commas-separated string to be split up
     * @return array
     */
    const split = function (val) {
        return val.split(/,\s*/);
    };

    /**
     * Returns the last item from a array
     * @param  array term - the array to retrieve the final item from
     * @return string
     */
    const extractLast = function (term) {
        return split(term).pop();
    };

    /**
     * Retrieves the "excludes" data attribute from an element
     * @param  string $excludes
     * @return string
     */
    const getExcludes = function ($excludes, $currentValues) {
        let excludeCurrentValues = [];
        let currentValues = JSON.parse($($currentValues).val());

        for (let i = 0; i < currentValues.length; i++) {
            excludeCurrentValues.push(currentValues[i].value);
        }

        return $($excludes).data("excludes").concat(excludeCurrentValues);
    };

    /**
     * Returns the jQuery element of from the provided event(?)
     * @param Event event
     * @return Element
     */
    const getJqueryElementForAutocomplete = function (event) {
        return $(event)[0].element[0];
    };

    /**
     * Attaches the autocomplete events to an element
     * @param  {[type]} $element [description]
     * @return {[type]}          [description]
     */
    const attachAutoCompleteEvent = function ($elementToBeAttached, autocompleteArgOptions) {
        if (autocompleteArgOptions.source === undefined
            || autocompleteArgOptions.select === undefined
        ) {
            console.error('Autocomplete option has not been defined');
            return false;
        }

        let autocompleteOptions = {
            ... autocompleteArgOptions,
            ... {
                appendTo: "#results-" + $($elementToBeAttached).attr("id"),
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                search: function () {
                    // Custom minLength - because using the standard jQuery behaviour does not
                    // work when there is already more than 3 characters
                    let term = extractLast(this.value);
                    if (term.length < 3) {
                        return false;
                    }
                }
            }
        };

        $($elementToBeAttached).on("keydown", function (event) {
            // Dont navigate away from the field on tab when selecting an item
            if (event.keyCode === $.ui.keyCode.TAB && $($elementToBeAttached).autocomplete("instance").menu.active) {
                event.preventDefault();
            }
        })
            .autocomplete(autocompleteOptions);
    };

    const addAutoCompleteValueToTable = function ($tableBody, label, value, targetForDelete) {
        $($tableBody)
        .append(`<tr><td>${label}</td><td><button class="btn btn-danger" onclick="removeAutocompleteItemFromTable(jQuery, this, '${targetForDelete}', ${value})" type="button">Remove</button></td></tr>`)
    }

    $("input.autocomplete").each(function () {
        let autoCompleteOptions = {
            select: function (event, ui) {
                let terms = split(this.value);
                // remove the current input
                terms.pop();
                // add the selected item
                if (ui.item.value !== "No results found") {
                    terms.push(ui.item.value);
                }
                // add placeholder to get the comma-and-space at the end
                terms.push("");
                this.value = terms.join(", ");
                return false;
            },
            source: function (request, response) {
                let $element = getJqueryElementForAutocomplete(this);
                $.getJSON($($element).data("source"), {
                    term: extractLast(request.term),
                    conditions: getExcludes($("#autocomplete-" + $($element).attr("name")))
                }, response);
                $(".ui-helper-hidden-accessible").remove();
            }
        };

        attachAutoCompleteEvent(
            $(this),
            autoCompleteOptions
        );
    });

    $("input.autocomplete-to-table").each(function () {
        let autocompleteFor = $(this).data('autocompleteFor');
        let $hiddenField    = $('#' + autocompleteFor);
        let $tableBody      = $('#autocomplete-' + autocompleteFor + '-table').find('tbody');
        let defaultValues   = JSON.parse($($hiddenField).val());

        $.each(defaultValues, function (index, defaultValue) {
            addAutoCompleteValueToTable($tableBody, defaultValue.label, defaultValue.value, autocompleteFor);
        });

        let autoCompleteOptions = {
            select: function (event, ui) {
                let autocompleteFor = $(this).data('autocompleteFor');
                let $hiddenField    = $('#' + autocompleteFor);
                let $table          = $('#autocomplete-' + autocompleteFor + '-table');
                let $tableBody      = $($table).find('tbody');
                let terms           = [];
                
                try {
                    terms = JSON.parse($($hiddenField).val());
                } catch {
                    console.warn('Terms could not be parsed');
                }

                // Add the selected item
                if (ui.item.value !== "No results found") {
                    terms.push(ui.item);

                    // add placeholder to get the comma-and-space at the end
                    // terms.push("");

                    // Update the hidden element with the updated data
                    $($hiddenField).val(JSON.stringify(terms)).change();

                    // Add the item to the table body
                    addAutoCompleteValueToTable($tableBody, ui.item.label, ui.item.value, autocompleteFor);

                    // Reset the current element to blank for the next item to be selected
                    this.value = '';
                }

                return false;
            },
            source: function (request, response) {
                // try {
                let $element           = getJqueryElementForAutocomplete(this);
                let sourceUrl          = $($element).data("source");
                let autocompleteFor    = $($element).data("autocompleteFor");
                let conditionalsString = $($element).data("conditionals").trim();
                let term = extractLast(request.term);
                let conditions = {
                    includes: [{
                        key: autocompleteFor,
                        value: term
                    }],
                    excludes: getExcludes(
                        $("#autocomplete-" + $($element).attr("name")),
                        $("#" + autocompleteFor)
                    )
                };
                if (conditionalsString !== "") {
                    let conditionalsArray = split(conditionalsString);
                    $.each(conditionalsArray, function (index, value) {
                        conditions.includes.push({
                            key: value,
                            value: parseInt($("[name=" + value + "]").val())
                        });
                    });
                }

                let conditionsJson = JSON.stringify(conditions);

                $.getJSON(sourceUrl, {
                    term: term,
                    conditions: conditionsJson,
                }, response);
                $(".ui-helper-hidden-accessible").remove();
            }
        };

        attachAutoCompleteEvent(
            $(this),
            autoCompleteOptions
        );
    });


    $('fieldset button.next-step').on('click', function () {
        let $parent = $(this).closest('fieldset');
        $($parent).hide();
        let $next = $($parent).next('fieldset');
        $($next).show();
        $($next).find('input[type=text],input[type=hidden],select,textarea').val('');
    });

    $('fieldset button.previous-step').on('click', function () {
        let $parent = $(this).closest('fieldset');
        $($parent).find('table.autocomplete-table tbody tr').remove();
        $($parent).hide().find('input[type=text],input[type=hidden],select,textarea').val('');
        $($parent).prev('fieldset').show();
    });

    // let list = $('table tbody.sortable');
    // list.sortable({
    //     cancel:'tr.add-item-row',
    //     placeholder: 'item-row-placeholder',
    //     update: function() {
    //         console.log('updated!');
    //         $.post('/timeline-segments/reorder', function(data) {
    //             window.location.href(window.location.href);
    //         });
    //     }
    // });

    // tinymce.init({
    //     menubar: false,
    //     plugins: [
    //         'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'print', 'preview', 'hr', 'anchor', 'spellchecker',
    //         'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime', 'nonbreaking',
    //         'autosave', 'table', 'contextmenu', 'directionality', 'emoticons', 'paste', 'textcolor'
    //     ],
    //     selector: '.textarea-editor',
    //     skin: 'default',
    //     statusbar: false,
    //     toolbar: 'undo redo | styleselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview | restoredraft code'
    // });


});
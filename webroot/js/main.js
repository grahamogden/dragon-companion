const setCookie = function(key, value) {
    let expires = new Date();
    expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));
    // let path = /((http\:\/\/)[a-z0-9:]*)/gm.exec(window.location.href)[0];
    document.cookie = key + '=' + value + ';path=/;expires=' + expires.toUTCString();
}

const getCookie = function(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}

jQuery(document).ready(function($) {
    const backgroundImages = [
        {
            url: 'battle_of_four_armies_by_jasonengle.jpg',
            slcted: true,
        },
        {
            url: '190622ddba35c1efab03fec90b427c65-d7pdb8i.png',
            slcted: false,
        },
        {
            url: 'commission__dungeons_and_dragons_party_by_kiralng-dbu4089.png',
            slcted: false,
        },
        {
            url: 'dungeons_and_dragons__minimalistic_party_wallpaper_by_conanultimate-d99abng.jpg',
            slcted: false,
        },
        {
            url: 'dungeons_and_dragons_party_by_uncannyknack-d7j7l0r.jpg',
            slcted: false,
        },
        {
            url: 'fantasy_asian_by_macduykhanh121094-da50lyq.jpg',
            slcted: false,
        },
    ];

    let transitionTime = 200;  // 0.2 seconds
    let intervalTime   = 7000; // 7 seconds

    /**
     * Retrieves the currently selected header background image
     * 
     * @return object
     */
    const getSelectedBackgroundImage = function () {
        let image;
        let i = 0;
        do {
            image = backgroundImages[i];
            i++;
        } while (image.slcted === false);
        return image;
    }

    /**
     * Randomly selects and image from the array and returns image file name and file type
     * 
     * @return string
     */
    const pickBackgroundImage = function () {
        let image;
        do {
            image = backgroundImages[Math.floor(Math.random()*backgroundImages.length)]
        } while (image.slcted === true);

        currentImage        = getSelectedBackgroundImage();
        currentImage.slcted = false;
        image.slcted        = true;

        return image.url;
    }

    /**
     * Switches out the background image of the header for a random one from the array
     * 
     * @param  object backgroundHeader 
     * @return void
     */
    const changeBackgroundImage = function(backgroundHeader) {
        url = pickBackgroundImage();

        backgroundHeader.css({
            "background-image": "url('/img/backgrounds/" + url + "')"
        });
    }

    /**
     * Adds the animation CSS property and then sets the interval to replace the background image
     */
    const backgroundSlider = function() {
        let backgroundHeader = $("#header-background");

        backgroundHeader.css({
            animation: "move-header-mobile " + (intervalTime / 1000) + "s linear infinite",
        });

        setInterval(function() {
            changeBackgroundImage($("#header-background"))
        }, intervalTime);
    }

    /**
     * Turns on or off the dark mode
     * @param bool isEnabled
     */
    const setDarkMode = function(isEnabled = false) {
        if (isEnabled === true) {
            window.localStorage.darkMode = 1;
            setCookie('darkMode', 1);
            $('body').addClass('dark-mode');
            $('#switch-dark-mode').prop('checked', true);
        } else {
            window.localStorage.removeItem('darkMode');
            setCookie('darkMode', 0);
            $('body').removeClass('dark-mode');
            $('#switch-dark-mode').prop('checked', false);
        }
    }

    /**
     * Toggles the header images to animate - currently only enables, cannot disable
     * @return void
     */
    const toggleHeaderSlider = function () {
        backgroundSlider();
    }

    // $('#top-bar').click(function() {
    //     url = pickBackgroundImage();

    //     $("#header-background").css({
    //         "background-image": "url('/img/backgrounds/" + url + "')"
    //     });
    // });

    // backgroundSlider();
    
    $('#switch-header-slider').click(function() {
        toggleHeaderSlider();
    });

    $('.menu-button').click(function(){
        $(this).parent('.actions').toggleClass('open');
        // $(this).siblings('.menu').slideToggle(transitionTime);
    });

    $('#nav-menu-button').click(function(){
        $('header nav').toggleClass('open');
        $(this).toggleClass('open');
    });

    $('.show-more-content').each(function() {
        let height = parseInt($(this).css('height'));
        if (height >= 260) {
            $(this)
                .parent()
                .addClass('active')
                .append('<a class="show-more-link"><span class="show">show</span><span class="hide">hide</span> more</a>');
        }
    });

    $('.show-more-link').on('click', function() {
        $(this)
            .parent('.show-more-container')
            .toggleClass('open');
    });

    // setDarkMode(getCookie('darkMode'));

    $('#switch-dark-mode').on('change', function() {
        let isChecked = $(this).is(':checked');
        // console.log(isChecked);
        setDarkMode(isChecked);
    });

    const split = function(val) {
        return val.split(/,\s*/);
    }

    const extractLast = function(term) {
        return split(term).pop();
    }

    const getExcludes = function(name) {
        return JSON.stringify($(name).data("excludes"));
    }

    const getJqueryElementForAutocomplete = function(event) {
        return $(event)[0].element[0];
    }
 
    $("input.autocomplete").each(function() {
        // dont navigate away from the field on tab when selecting an item
        $(this).on("keydown", function(event) {
                if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
                    event.preventDefault();
                }
            })
            .autocomplete({
                appendTo: "#results-" + $(this).attr("name"),
                source: function(request, response) {
                    let $element = getJqueryElementForAutocomplete(this);
                    $.getJSON($($element).data("source"), {
                        term: extractLast(request.term),
                        excludes: getExcludes("#autocomplete-" + $($element).attr("name"))
                    }, response);
                    $(".ui-helper-hidden-accessible").remove();
                },
                search: function() {
                    // Custom minLength - because using the standard jQuery behaviour does not
                    // work when there is already more than 3 characters
                    var term = extractLast(this.value);
                    if (term.length < 3) {
                        return false;
                    }
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function(event, ui) {
                    var terms = split(this.value);
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
                }
            });
    });
 
    $("input.autocomplete-table").each(function() {
        // dont navigate away from the field on tab when selecting an item
        $(this).on("keydown", function(event) {
                if (event.keyCode === $.ui.keyCode.TAB && $(this).autocomplete("instance").menu.active) {
                    event.preventDefault();
                }
            })
            .autocomplete({
                appendTo: "#results-" + $(this).attr("name"),
                source: function(request, response) {
                    let $element = getJqueryElementForAutocomplete(this);
                    $.getJSON($($element).data("source"), {
                        term: extractLast(request.term),
                        excludes: getExcludes("#autocomplete-" + $($element).attr("name"))
                    }, response);
                    $(".ui-helper-hidden-accessible").remove();
                },
                search: function() {
                    // Custom minLength - because using the standard jQuery behaviour does not
                    // work when there is already more than 3 characters
                    var term = extractLast(this.value);
                    if (term.length < 3) {
                        return false;
                    }
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function(event, ui) {
                    var terms = split(this.value);
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
                }
            });
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
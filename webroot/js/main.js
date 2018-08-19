var textAreaMode = false;
var textareaCombinationKeys = {
    b: {
        command: 'bold',
        preventDefault: true,
    },
    i: {
        command: 'italic',
        preventDefault: true,
    },
    u: {
        command: 'underline',
        preventDefault: true,
    },
    v: {
        command: 'paste',
        preventDefault: false,
    }
};
var editorTextareas = {};

jQuery(document).ready(function($) {
    let backgroundImages = [
        "battle_of_four_armies_by_jasonengle.jpg",
        "190622ddba35c1efab03fec90b427c65-d7pdb8i.png",
        "commission__dungeons_and_dragons_party_by_kiralng-dbu4089.png",
        "dungeons_and_dragons__minimalistic_party_wallpaper_by_conanultimate-d99abng.jpg",
        "dungeons_and_dragons_party_by_uncannyknack-d7j7l0r.jpg",
        "fantasy_asian_by_macduykhanh121094-da50lyq.jpg",
    ];

    let transitionTime = 200; // 0.2 seconds
    let intervalTime = 7000; // 7 seconds

    /**
     * Randomly selects and image from the array and returns the string
     */
    let pickBackgroundImage = function (currentUrl) {
        return backgroundImages[Math.floor(Math.random()*backgroundImages.length)];
    }

    /**
     * Adds the animation CSS property and then sets the interval to replace the background image
     */
    let backgroundSlider = function() {
        var backgroundHeader = $("#header-background");

        backgroundHeader.css({
            animation: "move-header-mobile " + (intervalTime / 1000) + "s linear infinite",
        });

        // backgroundHeader.addClass('animate');

        var url = '';

        setInterval(function() {
            let currentUrl = backgroundHeader.css('background-image');
            url = pickBackgroundImage(currentUrl);

            backgroundHeader.css({
                "background-image": "url('/img/backgrounds/" + url + "')"
            });
        }, intervalTime);
    }

    // backgroundSlider();

    $('.menu-button').click(function(){
        $(this).parent().toggleClass('open');
        $(this).siblings('ul').slideToggle(transitionTime);
    });

    $('#nav-menu-button').click(function(){
        $('header nav').toggleClass('open');
        $(this).toggleClass('open');
    });

    $('.show-more-container').each(function() {
        let height = parseInt($(this).css('height'));
        if (height >= 200) {
            $(this)
                .addClass('active')
                .append('<a class="show-more-link"><span class="show">show</span><span class="hide">hide</span> more</a>');
        }
    });

    $('.show-more-link').on('click', function() {
        $(this)
            .parent('.show-more-container')
            .toggleClass('open');
    });

    var setDarkMode = function(isEnabled = false) {
        if (isEnabled === true) {
            console.log('enabling dark mode');
            localStorage.darkMode = 'true';
            $('body').addClass('dark-mode');
            $('#switch-color-scheme').prop('checked', true);
        } else {
            console.log('disabling dark mode');
            localStorage.removeItem('darkMode');
            $('body').removeClass('dark-mode');
            $('#switch-color-scheme').prop('checked', false);
        }
    }

    $('#switch-color-scheme').on('change', function() {
        let isChecked = $(this).is(':checked');
        console.log(isChecked);
        setDarkMode(isChecked);
    });

    setDarkMode(localStorage.darkMode === 'true');

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

    /**
     * Text areas START
     */
    
    /**
     * Loops over each available textarea-editor on the page,
     * initialises it and then adds events for functionality
     * 
     * @return void
     */
    $('.textarea-editor-content').each(function() {
        // Grab the data from the hidden input and put it in the "content"
        let html = $('#' + $(this).data('for')).val();
        $(this).html(html);
        // init the text area editor
        initTextareaEditor($(this));
        // Bind on key down to allow users to use ctrl + B to bolden text, etc.
        $(this).on('keydown', function(event) {
            if (combinationKeyCheck(event)) {
                formatDoc(textareaCombinationKeys[event.key].command);
            }
        });
    });

    /**
     * Attach "keydown" listener so that if the user clicks ctrl + B
     * to bolden the text, we can prevent it from opening their bookmarks
     */
    $(document).on('keydown', function(event) {
        // Only prevent default if we have specified it in the combination keys list
        if (combinationKeyCheck(event) && textareaCombinationKeys[event.key].preventDefault) {
            event.preventDefault();
            event.stopPropagation();
        }
    });

    /**
     * When submitting the form, take the values for each of the text editors,
     * format it and then put it into the hidden field associated to the editor
     */
    $('form').on('submit', function() {
        $('.textarea-editor').each(function() {
            let editorContent = $(this).children('.textarea-editor-content');

            $(editorContent).find('*:not(td)').filter(function(){
                return $.trim(this.innerHTML) === ""
            }).remove();

            let html = editorContent
                .html()
                .replace(/\<br.*?\/?\>/g,'') // remove br tags
                .replace(/((\>)\s*)/g,'$2')
                .replace(/(\s*(\<))/g,'$1');
            $('#' + editorContent.data('for')).val(html);
        });
    });

});

/**
 * Checks to see if the user has hit the ctrl (windows)/cmd(mac) key and
 * a key that we know the user might be trying to perform, such as B for bold
 */
var combinationKeyCheck = function (event) {
    console.log('ctrl|meta: ' + (event.ctrlKey || event.metaKey) + '; ' + event.key);
    return ((event.ctrlKey || event.metaKey)
        && textareaCombinationKeys[event.key] !== undefined
    ) ? true : false;
}

/**
 * Initialises the textarea provided
 * 
 * @param  object $element - jQuery element object 
 * 
 * @return void
 */
var initTextareaEditor = function($element) {
    document.execCommand("defaultParagraphSeparator", false, "p");
    editorTextareas[$element.attr('id')] = $element;
    if (textAreaMode) {
        setTextareaMode(true);
    }
}

/**
 * Formats the selected text using the passed command
 * 
 * @param  string cmd   - The command to be executed (bold, underline, etc.)
 * @param  string value - Any value required (mainly the link for adding hyperlink)
 * 
 * @return void
 */
var formatDoc = function(cmd, value) {
    if (validateMode()) {
        document.execCommand(cmd, false, value);
    }
}

/**
 * Ensures not to allow submission when in HTML source mode
 * 
 * @return bool
 */
var validateMode = function() {
    if (!textAreaMode) {
        return true;
    }

    alert("Uncheck \"Show HTML\".");
    editorTextareas[elementId].focus();
    return false;
}

/**
 * Changes whether to display the content as HTML source code or fomatted text
 * 
 * @param bool   setToSourceMode - true = Sets the element to display as HTML source; false = Display as text
 * @param string elementId       - The target element ID
 */
var setTextareaMode = function(setToSourceMode, elementid) {
    let content;

    if (setToSourceMode) {
        content = document.createTextNode(editorTextareas[elementId].innerHTML);
        editorTextareas[elementId].innerHTML = "";
        let oPre = document.createElement("pre");
        editorTextareas[elementId].contentEditable = false;
        oPre.id = "sourceText";
        oPre.contentEditable = true;
        oPre.appendChild(content);
        editorTextareas[elementId].appendChild(oPre);
    } else {
        if (document.all) {
            editorTextareas[elementId].innerHTML = editorTextareas[elementId].innerText;
        } else {
            content = document.createRange();
            content.selectNodeContents(editorTextareas[elementId].firstChild);
            editorTextareas[elementId].innerHTML = content.toString();
        }
        editorTextareas[elementId].contentEditable = true;
    }
    editorTextareas[elementId].focus();
}
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
var backspaceIsPressed = false;
var autoSaveTimeout;
var autoSaveWaitTime = 1500;

jQuery(document).ready(function($) {
    let backgroundImages = [
        'battle_of_four_armies_by_jasonengle.jpg',
        '190622ddba35c1efab03fec90b427c65-d7pdb8i.png',
        'commission__dungeons_and_dragons_party_by_kiralng-dbu4089.png',
        'dungeons_and_dragons__minimalistic_party_wallpaper_by_conanultimate-d99abng.jpg',
        'dungeons_and_dragons_party_by_uncannyknack-d7j7l0r.jpg',
        'fantasy_asian_by_macduykhanh121094-da50lyq.jpg',
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
            window.localStorage.darkMode = 'true';
            $('body').addClass('dark-mode');
            $('#switch-color-scheme').prop('checked', true);
        } else {
            console.log('disabling dark mode');
            window.localStorage.removeItem('darkMode');
            $('body').removeClass('dark-mode');
            $('#switch-color-scheme').prop('checked', false);
        }
    }

    $('#switch-color-scheme').on('change', function() {
        let isChecked = $(this).is(':checked');
        console.log(isChecked);
        setDarkMode(isChecked);
    });

    setDarkMode(window.localStorage.darkMode === 'true');

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
    
    let autoSave = function(name, id, content) {
        let parent = $('#textarea-editor-' + name);
        parent.addClass('auto-saving');
        // Remove the autosave text
        setTimeout(function() {
            $(parent).removeClass('auto-saving');
        }, 3000);
        // Save the data
        localStorage.setItem('autoSave-' + name + '-' + id, content);
        // Remove the pulse from the Restore icon, because it has now been overwritten
        parent.find('.icon-restore').removeClass('pulse');
    }

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

        // Get the autosave data
        let editor       = $(this).parent('.textarea-editor');
        let autoSaveName = editor.data('name');
        let autoSaveId   = editor.data('id');
        let autoSaveData = window.localStorage.getItem('autoSave-' + autoSaveName + '-' + autoSaveId);

        // init the text area editor
        initTextareaEditor($(this));
        // Bind on key down to allow users to use ctrl + B to bolden text, etc.
        $(this)
            .on('keydown', function(event) {
                if (combinationKeyCheck(event)) {
                    formatDoc(textareaCombinationKeys[event.key].command);
                // } else {
                //     autoSave($(this).html(), $(this).data('autoSaveName'));
                }
            })
            // Bind on key up to autosave any content from the 
            .on('keyup', function(event) {
                if (!combinationKeyCheck(event)) {
                    // autoSave($(this).html(), $(this).data('autoSaveName'));
                    let content = $(this).html();
                    if (autoSaveTimeout) {
                        clearInterval(autoSaveTimeout);
                    }
                    autoSaveTimeout = setTimeout(function() {
                        autoSave(autoSaveName, autoSaveId, content)
                    }, autoSaveWaitTime);
                }
            })
            .on('focus', function(event) {
                resizeTextareaEditor();
            });


        if (autoSaveData && html !== autoSaveData) {
            console.log(html);
            console.log(autoSaveData);
            editor.find('.icon-restore').addClass('pulse');
        }
    });

    /**
     * Attach "keydown" listener so that if the user clicks ctrl + B
     * to bolden the text, we can prevent it from opening their bookmarks
     */
    $(document).on('keydown', function(event) {
        // console.log(event.key);
        // Only prevent default if we have specified it in the combination keys list
        if (
            (combinationKeyCheck(event) && textareaCombinationKeys[event.key].preventDefault)
            // || event.key.toLower() == 'backspace'
        ) {
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
            let name          = $(this).data('name');
            let id            = $(this).data('id');
            let editorContent = $(this).children('.textarea-editor-content');

            $(editorContent).find('*:not(td,hr)').filter(function(){
                return $.trim(this.innerHTML) === ""
            }).remove(); // Remove empty tags, which aren't TDs or HRs

            let html = editorContent
                .html()
                .replace(/(\<\/?(br|span).*?\/?\>|\n|\t)/g,'') // Remove br tags, new lines and tabs
                .replace(/\&nbsp\;/g, ' '); // Replace non-break spaces with normal spaces
                // .replace(/((\>)\s{2,})/g,'$2') // Remove spaces after tags
                // .replace(/(\s{2,}(\<))/g,'$1'); // Remove spaces before tags
            // Put the formatted string back into the hidden input
            $('#' + editorContent.data('for')).val(html);

            window.localStorage.removeItem('autoSave-' + name + '-' + id);
        });
    });

    $(window)
        .keydown(function(event){
            if (event.key.toLowerCase() == 'backspace') {
                backspaceIsPressed = true;
            }
        })
        .keyup(function(event){
            if (event.key.toLowerCase() == 'backspace') {
                backspaceIsPressed = false;
            }
        }).on('beforeunload', function() {
            if (backspaceIsPressed) {
                backspaceIsPressed = false
                return 'It looks like you have been editing something, are you sure you want to contine? All unsaved changes will be lost!';
            }
        })
        .resize(function() {
            if ($('body').hasClass('full-screen')) {
                resizeTextareaEditor();
            }
        });
});

/**
 * Checks to see if the user has hit the ctrl (windows)/cmd(mac) key and
 * a key that we know the user might be trying to perform, such as B for bold
 */
var combinationKeyCheck = function (event) {
    // console.log('ctrl|meta: ' + (event.ctrlKey || event.metaKey) + '; ' + event.key);
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
    document.execCommand('defaultParagraphSeparator', false, 'p');
    document.execCommand('enableInlineTableEditing', false, false);
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
        editorTextareas[elementId].innerHTML = '';
        let oPre = document.createElement('pre');
        editorTextareas[elementId].contentEditable = false;
        oPre.id = 'sourceText';
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

var fullscreen = function(id) {
    jQuery('#' + id).toggleClass('full-screen');
    jQuery('body').toggleClass('full-screen');
    resizeTextareaEditor(id);
}

var resizeTextareaEditor = function(id) {
    let editor  = $('#' + id);
    let content = editor.find('.textarea-editor-content');
    if ($('body').hasClass('full-screen')) {
        let toolbar        = editor.find('.textarea-editor-toolbar');
        let toolbarHeight  = toolbar.height();
        let newHeight      = window.innerHeight;
        content.css({
            'margin-top' : toolbarHeight + 'px',
            // 'height'     : (newHeight - toolbarHeight) + 'px'
        });
    } else {
        content.removeAttr('style');
    }
}

var openAutoSave = function(name, id) {
    // console.log(name + '-' + id);
    let autoSaveData = window.localStorage.getItem('autoSave-' + name + '-' + id);
    // console.log(autoSaveData);
    if (autoSaveData) {
        console.log('Restoring auto save');
        // Update the hidden input
        jQuery('#textarea-editor-input-' + name).val(autoSaveData);
        // Update the actual visible input
        jQuery('#textarea-editor-content-' + name).html(autoSaveData);
        jQuery('#textarea-editor-' + name).find('.icon-restore').removeClass('pulse');
    }
}
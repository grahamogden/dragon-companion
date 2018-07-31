var textAreaMode = false;
var textareaCombinationKeys = {
    b: 'bold',
    i: 'italic',
    u: 'underline',
};

jQuery(document).ready(function($) {
    let backgroundImages = [
        "battle_of_four_armies_by_jasonengle.jpg",
        "190622ddba35c1efab03fec90b427c65-d7pdb8i.png",
        "commission__dungeons_and_dragons_party_by_kiralng-dbu4089.png",
        "dungeons_and_dragons__minimalistic_party_wallpaper_by_conanultimate-d99abng.jpg",
        "dungeons_and_dragons_party_by_uncannyknack-d7j7l0r.jpg",
        "fantasy_asian_by_macduykhanh121094-da50lyq.jpg",
    ];

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

    $('#nav-menu-button').click(function(){
        $('header nav').toggleClass('open');
        $(this).toggleClass('open');
    });

    $('.menu-button').click(function(){
        $(this).siblings('ul').slideToggle(); // toggleClass('open');
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

    /**
     * Text areas START
     */
    
    /**
     * Loops over each available textarea-editor on the page,
     * initialises it and then adds events for functionality
     * 
     * @return void
     */
    $('.textarea-editor').each(function() {
        initTextareaEditor($(this));
        $(this).on('keydown', function(event) {
            if (combinationKeyCheck(event)) {
                formatDoc(textareaCombinationKeys[event.key], $(this).attr('id'));
            }
        });
    });

    $(document).on('keydown', function(event) {
        if (combinationKeyCheck(event)) {
            event.preventDefault();
            event.stopPropagation();
        }
    });

    var combinationKeyCheck = function (event) {
        return ((event.ctrlKey || event.metaKey)
            && textareaCombinationKeys[event.key] !== undefined
        ) ? true : false;
    }

});
    
    var editorTextareas = {};


    /**
     * Initialises the textarea provided
     * 
     * @param  object $element - jQuery element object 
     * 
     * @return void
     */
    function initTextareaEditor($element) {
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
    function formatDoc(cmd, elementId, value) {
        if (validateMode()) {
            document.execCommand(cmd, false, value);
            editorTextareas[elementId].focus();
        }
    }

    /**
     * Ensures not to allow submission when in HTML source mode
     * 
     * @return bool
     */
    function validateMode() {
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
    function setTextareaMode(setToSourceMode, elementid) {
        var content;

        if (setToSourceMode) {
            content = document.createTextNode(editorTextareas[elementId].innerHTML);
            editorTextareas[elementId].innerHTML = "";
            var oPre = document.createElement("pre");
            editorTextareas[elementId].contentEditable = false;
            oPre.id = "sourceText";
            oPre.contentEditable = true;
            oPre.appendChild(content);
            editorTextareas[elementId].appendChild(oPre);
            document.execCommand("defaultParagraphSeparator", false, "p");
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
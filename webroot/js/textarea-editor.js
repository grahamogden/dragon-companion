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

    /**
     * Checks to see if the user has hit the ctrl (windows)/cmd(mac) key and
     * a key that we know the user might be trying to perform, such as B for bold
     */
    let combinationKeyCheck = function (event) {
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
    let initTextareaEditor = function($element) {
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
    let formatDoc = function(event) {
        console.log('formatDoc: ' + event.data.cmd);
        if (validateMode()) {
            document.execCommand(event.data.cmd, false, event.data.value);
        }
    }

    /**
     * Ensures not to allow submission when in HTML source mode
     * 
     * @return bool
     */
    let validateMode = function() {
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
    let setTextareaMode = function(setToSourceMode, elementid) {
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

    /**
     * TODO: get inserting tables working
     * 
     * @param  string id
     * @return void
     */
    let insertTable = function (id) {
        let i    = 0;
        let rows  = '';
        for (i = 0; i < 3; i++) {
            let j = 0;
            rows += '<tr>';
            for (j = 0; j < 4; j++) {
                rows += '<td></td>'
            }
            rows += '</tr>';
        }
        table = document.createElement('table');
        table.innerHTML = rows;
        console.log(table);
        console.log('table added');
        
        insertNodeOverSelection(table, document.getElementById(id));
    }

    /**
     * 
     * @param  object  ancestor
     * @param  object  descendant
     * @return bool
     */
    let isOrContainsNode = function (ancestor, descendant) {
        var node = descendant;
        while (node) {
            if (node === ancestor) return true;
            node = node.parentNode;
        }
        return false;
    }

    /**
     * Inserts a node into the container
     * 
     * @param  object node
     * @param  object containerNode
     * @return void
     */
    let insertNodeOverSelection = function(node, containerNode) {
        var sel, range, html;
        if (window.getSelection) {
            sel = window.getSelection();
            if (sel.getRangeAt && sel.rangeCount) {
                range = sel.getRangeAt(0);
                if (isOrContainsNode(containerNode, range.commonAncestorContainer)) {
                    range.deleteContents();
                    range.insertNode(node);
                } else {
                    containerNode.appendChild(node);
                }
            }
        } else if (document.selection && document.selection.createRange) {
            range = document.selection.createRange();
            if (isOrContainsNode(containerNode, range.parentElement())) {
                html = (node.nodeType == 3) ? node.data : node.outerHTML;
                range.pasteHTML(html);
            } else {
                containerNode.appendChild(node);
            }
        }
    }

    /**
     * Adds the full-screen class to the textarea editor and body,
     * so that the correct styles can be applied
     * 
     * @param  string id
     * @return void
     */
    let fullscreen = function(id) {
        jQuery('#' + id).toggleClass('full-screen');
        jQuery('body').toggleClass('full-screen');
        resizeTextareaEditor(id);
    }

    /**
     * Recalculates the margin of the top based on the size of the toolbar
     * 
     * @param  string id
     * @return void
     */
    let resizeTextareaEditor = function(id) {
        let editor  = $('#' + id);
        let content = editor.find('.textarea-editor-content');
        if ($('body').hasClass('full-screen')) {
            let toolbar        = editor.find('.textarea-editor-toolbar');
            let toolbarHeight  = toolbar.height();
            let newHeight      = window.innerHeight;
            content.css({
                'margin-top' : toolbarHeight + 'px',
            });
        } else {
            content.removeAttr('style');
        }
    }
    
    /**
     * Waits until the user has stopped interacting with editor
     * and will then save to local storage
     * 
     * @param  string name
     * @param  string id
     * @param  string content
     * @return void
     */
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
     * Retrieves the content from local storage
     * 
     * @param  string name
     * @param  string id
     * @return void
     */
    let openAutoSave = function(name, id) {
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

    /**
     * Not the same as full screen, this allows the editor to extend
     * to its natural, unrestricted height
     * 
     * @param  string id
     * @return void
     */
    let switchAutoHeight = function(id) {
        console.log(id);
        jQuery('#' + id).toggleClass('auto-height');
    }

    $('.textarea-editor .icon-undo')
        .click({cmd: 'undo'}, formatDoc);
    $('.textarea-editor .icon-redo')
        .click({cmd: 'redo'}, formatDoc);
    $('.textarea-editor .icon-bold')
        .click({cmd: 'bold'}, formatDoc);
    $('.textarea-editor .icon-italic')
        .click({cmd: 'italic'}, formatDoc);
    $('.textarea-editor .icon-underline')
        .click({cmd: 'underline'}, formatDoc);
    $('.textarea-editor .icon-strikethrough')
        .click({cmd: 'strikeThrough'}, formatDoc);
    $('.textarea-editor .icon-ol')
        .click({cmd: 'insertorderedlist'}, formatDoc);
    $('.textarea-editor .icon-ul')
        .click({cmd: 'insertunorderedlist'}, formatDoc);
    $('.textarea-editor .icon-unindent')
        .click({cmd: 'outdent'}, formatDoc);
    $('.textarea-editor .icon-indent')
        .click({cmd: 'indent'}, formatDoc);
    $('.textarea-editor .icon-hr')
        .click({cmd: 'insertHorizontalRule'}, formatDoc);
    $('.textarea-editor .icon-table')
        .click(function() {
            // insertTable('textarea-editor-content-' + $(this).closest('.textarea-editor').data('name'));
        });
    $('.textarea-editor .icon-restore')
        .click(function() {
            let editor = $(this).closest('.textarea-editor');
            openAutoSave(
                editor.data('name'),
                editor.data('id'));
        });
    $('.textarea-editor .icon-full-screen')
        .click(function() {
            fullscreen('textarea-editor-' + $(this).closest('.textarea-editor').data('name'));
        });
    $('.textarea-editor .icon-auto-height')
        .click(function () {
            switchAutoHeight('textarea-editor-' + $(this).closest('.textarea-editor').data('name'));
        });

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
            editor.find('.icon-restore').addClass('pulse');
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
        /**
         * Attach "keydown" so that if the user hits ctrl + B (for example),
         * we can prevent it from opening their bookmarks
         */
        .keydown(function(event){
            if (event.key.toLowerCase() == 'backspace') {
                backspaceIsPressed = true;
            }
            // Only prevent default if we have specified it in the combination keys list
            if (combinationKeyCheck(event) && textareaCombinationKeys[event.key].preventDefault) {
                event.preventDefault();
                event.stopPropagation();
            }
        })
        .keyup(function(event){
            if (event.key.toLowerCase() == 'backspace') {
                backspaceIsPressed = false;
            }
        })
        .on('beforeunload', function() {
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
let textAreaMode = false;
let textareaCombinationKeys = {
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
let editorTextareas = {};
let backspaceIsPressed = false;
let autoSaveTimeout;
let autoSaveWaitTime = 1500;

/**
 * Recalculates the margin of the top based on the size of the toolbar
 * 
 * @param  string id
 * @param  string triggerClass - the class that determines how the toolbar should behave
 * @return void
 */
let resizeTextareaEditor = function(editor, triggerClass) {
    // console.log('resize');
    let content = editor.find('.textarea-editor-content');
    if (jQuery(editor).hasClass(triggerClass)) {
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

let cleanHtml = function(html) {
    return html
        .replace(/(\<\/?(br|span).*?\/?\>|\n|\t)/g,'') // Remove br tags, new lines and tabs
        .replace(/\&nbsp\;/g, ' ');
        // .replace(/((\>)\s{2,})/g,'$2') // Remove spaces after tags
        // .replace(/(\s{2,}(\<))/g,'$1'); // Remove spaces before tags
}

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
        console.log('defaultParagraphSeparator');
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
        if (validateMode()) {
            // console.log(event.data.cmd);
            // console.log(event.data.value);
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
     * Inserts a table into the textarea editor
     * 
     * @param  string id
     * @param  int    rowMax
     * @param  int    colMax
     * @return void
     */
    let insertTable = function (id, rowMax = 2, colMax = 2) {
        let i    = 0;
        let rows  = '';
        for (i = 0; i < rowMax; i++) {
            let j = 0;
            rows += '<tr>';
            for (j = 0; j < colMax; j++) {
                rows += '<td></td>';
            }
            rows += '</tr>';
        }
        table = '<table>' + rows + '</table>';
        // Add the table
        formatDoc({data:{
            cmd: 'insertHTML',
            value: table
        }});
    }

    /**
     * TODO: get inserting row working
     * 
     * @param  string id
     * @return void
     */
    let insertRow = function (id) {
        let parentNode    = window.getSelection().getRangeAt(0).commonAncestorContainer;
        let tableBodyNode = getParentNode(parentNode, 'table');
        let columnCount   = getParentNode(parentNode, 'tbody').children.length;
        let cellString    = '';
        let newRow = document.createElement('tr');
        for (i = 0; i < columnCount; i++) {
            newRow.appendChild(document.createElement('td'));
        }
        
        tableBodyNode.appendChild(newRow);
        let table = getParentNode(tableBodyNode);

        html = table.outerHTML;
        html = cleanHtml(html);
        console.log(html);
        $(table).remove();

        formatDoc({data:{
            cmd: 'insertHTML',
            value: html
        }});
    }

    /**
     * TODO: get inserting column working
     * 
     * @param  string id
     * @return void
     */
    let insertColumn = function (id) {
        let parentNode    = window.getSelection().getRangeAt(0).commonAncestorContainer;
        let tableBodyNode = getParentNode(parentNode, 'table');
        let rows          = tableBodyNode.children;

        $(tableBodyNode).children('tr').each(function() {
            // let rowNode = getParentNode(parentNode, 'tbody');
            // rowNode.appendChild();
            console.log($(this));
            $(this).append($('<td></td>'));
        });
        // let table = getParentNode(tableBodyNode);

        // html = table.outerHTML;
        // html = cleanHtml(html);
        // console.log(html);
        // $(table).remove();

        // formatDoc({data:{
        //     cmd: 'insertHTML',
        //     value: html
        // }});
    }

    /**
     * 
     * @param  object  ancestor
     * @param  object  descendant
     * @return bool
     */
    let isOrContainsNode = function (ancestor, descendant) {
        let node = descendant;
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
        let sel, range, html;
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
     * Finds the highest level node 
     * @param  node currentNode
     * @param  node parentTargetNodeName
     * @return node
     */
    let getParentNode = function(currentNode, parentTargetNodeName = false) {
        let parentNode = currentNode.parentElement;
        // console.log(parentNode);
        // console.log($(parentNode));
        if ((parentTargetNodeName && 
                parentNode.nodeName.toLowerCase() == parentTargetNodeName.toLowerCase())
            || $(parentNode).hasClass('textarea-editor-content')
        ) {
            return currentNode;
        } else {
            return getParentNode(parentNode, parentTargetNodeName);
        }
    }

    /**
     * Adds the full-screen class to the textarea editor and body,
     * so that the correct styles can be applied
     * 
     * @param  string id
     * @return void
     */
    let fullscreen = function(editor) {
        let triggerClass = 'full-screen';
        $(editor).toggleClass(triggerClass);
        $('body').toggleClass(triggerClass);
    }

    let toggleToolbar = function(editor) {
        $(editor).toggleClass('show-toolbar');
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
            // console.log('Restoring auto save');
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
        // console.log(id);
        jQuery('#' + id).toggleClass('auto-height');
    }

    $('.textarea-editor .icon-undo')
        .mousedown({cmd: 'undo'}, formatDoc);
    $('.textarea-editor .icon-redo')
        .mousedown({cmd: 'redo'}, formatDoc);
    $('.textarea-editor .icon-bold')
        .mousedown({cmd: 'bold'}, formatDoc);
    $('.textarea-editor .icon-italic')
        .mousedown({cmd: 'italic'}, formatDoc);
    $('.textarea-editor .icon-underline')
        .mousedown({cmd: 'underline'}, formatDoc);
    $('.textarea-editor .icon-strikethrough')
        .mousedown({cmd: 'strikeThrough'}, formatDoc);
    $('.textarea-editor .icon-ol')
        .mousedown({cmd: 'insertorderedlist'}, formatDoc);
    $('.textarea-editor .icon-ul')
        .mousedown({cmd: 'insertunorderedlist'}, formatDoc);
    $('.textarea-editor .icon-unindent')
        .mousedown({cmd: 'outdent'}, formatDoc);
    $('.textarea-editor .icon-indent')
        .mousedown({cmd: 'indent'}, formatDoc);
    $('.textarea-editor .icon-hr')
        .mousedown({cmd: 'insertHorizontalRule'}, formatDoc);
    $('.textarea-editor .icon-table')
        .mousedown(function() {
            insertTable('textarea-editor-content-' + $(this).closest('.textarea-editor').data('name'));
        });
    $('.textarea-editor .icon-add-row')
        .mousedown(function() {
            insertRow('textarea-editor-content-' + $(this).closest('.textarea-editor').data('name'));
        });
    $('.textarea-editor .icon-add-column')
        .mousedown(function() {
            insertColumn('textarea-editor-content-' + $(this).closest('.textarea-editor').data('name'));
        });
    $('.textarea-editor .icon-restore')
        .mousedown(function() {
            let editor = $(this).closest('.textarea-editor');
            openAutoSave(
                editor.data('name'),
                editor.data('id'));
        });
    $('.textarea-editor .icon-full-screen')
        .mousedown(function() {
            fullscreen($('#textarea-editor-' + $(this).closest('.textarea-editor').data('name')));
        });
    $('.textarea-editor .icon-auto-height')
        .mousedown(function () {
            switchAutoHeight('textarea-editor-' + $(this).closest('.textarea-editor').data('name'));
        });
    $('.textarea-editor .toggle-toolbar')
        .mousedown(function() {
            toggleToolbar($('#textarea-editor-' + $(this).closest('.textarea-editor').data('name')));
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
                    formatDoc({data: {cmd: textareaCombinationKeys[event.key].command}});
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
            /*.on('focus', function(event) {
                resizeTextareaEditor();
            })*/;


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

            let html = cleanHtml(editorContent
                .html()); // Replace non-break spaces with normal spaces
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
        /*.resize(function() {
            if ($('body').hasClass('full-screen')) {
                resizeTextareaEditor();
            }
        })*/;
});
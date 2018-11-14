jQuery(document).ready(function($) {
    var Embed = Quill.import('blots/block/embed');

    class Hr extends Embed {
        static create(value) {
            let node = super.create(value);
            // give it some margin
            // node.setAttribute('style', "height:0px; margin-top:10px; margin-bottom:10px;");
            return node;
        }
    }

    Hr.blotName  = 'hr'; //now you can use .ql-hr classname in your toolbar
    Hr.className = 'my-hr';
    Hr.tagName   = 'hr';

    var customHrHandler = function(){
        // get the position of the cursor
        var range = quill.getSelection();
        if (range) {
            // insert the <hr> where the cursor is
            quill.insertEmbed(range.index,"hr","null")
        }
    }

    Quill.register({
        'formats/hr': Hr
    });

    var options = {
        debug: 'error',
        modules: {
            toolbar: [
                [{
                    header: [1, 2, false],
                }],
                [
                    'bold',
                    'italic',
                    'underline',
                    'strike'
                ],
                [
                    { 'list': 'ordered' },
                    { 'list': 'bullet' }
                ],
                [
                    { 'indent': '-1' },
                    { 'indent': '+1' }
                ],
                [
                    'table',
                    {'hr': customHrHandler}
                ]
            ],
            table: true,
            history: {
                delay: 1000,
                maxStack: 500,
                userOnly: true
            }
        },
        scrollingContainer: '.textarea-editor-2-content',
        placeholder: 'Compose an epic...',
        theme: 'snow'
    };
    var editor = new Quill('.textarea-editor-2-content', options); // First matching element will be used

    // Enable all tooltips
    // $('[data-toggle="tooltip"]').tooltip();
    // Can control programmatically too
    // $('.ql-formats button').mouseover();

    const table = editor.getModule('table');

    $('.textarea-editor-2 .icon-table').click(function() {
        table.insertTable(2, 2);
    });

    $('.textarea-editor-2 .icon-row-above').click(function() {
        table.insertRowAbove();
    });

    $('.textarea-editor-2 .icon-row-below').click(function() {
        table.insertRowBelow();
    });

    $('.textarea-editor-2 .icon-column-left').click(function() {
        table.insertColumnLeft();
    });

    $('.textarea-editor-2 .icon-column-right').click(function() {
        table.insertColumnRight();
    });

    $('.textarea-editor-2 .icon-delete-row').click(function() {
        table.deleteRow();
    });

    $('.textarea-editor-2 .icon-delete-column').click(function() {
        table.deleteColumn();
    });

    $('.textarea-editor-2 .icon-delete-table').click(function() {
        table.deleteTable();
    });

    $('.textarea-editor-2 .icon-hr').click(function() {
        editor.insertEmbed(1, 'html', '<hr/>');
    });

    $('.textarea-editor-2 .icon-full-screen')
        .mousedown(function() {
            fullscreen($('#textarea-editor-2-' + $(this).closest('.textarea-editor').data('name')));
        });
    $('.textarea-editor-2 .icon-auto-height')
        .mousedown(function () {
            switchAutoHeight('textarea-editor-2-' + $(this).closest('.textarea-editor').data('name'));
        });
    $('.textarea-editor-2 .toggle-toolbar')
        .mousedown(function() {
            toggleToolbar($('#textarea-editor-2-' + $(this).closest('.textarea-editor').data('name')));
        });

    var updateOutput = function(editor) {
        let output = editor.getContents();
                $(editorContent).find('*:not(td,hr)').filter(function(){
            return $.trim(this.innerHTML) === ""
        }).remove(); // Remove empty tags, which aren't TDs or HRs

        let html = cleanHtml(editorContent.html()); // Replace non-break spaces with normal spaces
        return output;
    }

    let cleanHtml = function(html) {
        return html
            .replace(/(\<\/?(br|span).*?\/?\>|\n|\t)/g,'') // Remove br tags, new lines and tabs
            .replace(/\&nbsp\;/g, ' ');
            // .replace(/((\>)\s{2,})/g,'$2') // Remove spaces after tags
            // .replace(/(\s{2,}(\<))/g,'$1'); // Remove spaces before tags
    }

    /**
     * When submitting the form, take the values for each of the text editors,
     * format it and then put it into the hidden field associated to the editor
     */
    $('form').on('submit', function() {
        $('.textarea-editor-2').each(function() {
            let name          = $(this).data('name');
            let id            = $(this).data('id');

            // console.log(editor);

            let editorContainer = $(this).children('.textarea-editor-2-content');
            let editorContent = $(editorContainer).children('.ql-editor');

            // $('#' + $(this).children('.textarea-editor-2-content').data('for')).val(
            //     updateOutput(editor)
            // );
            
            // let output = JSON.stringify(editor.getContents());
            let output = $(editorContent).html();
            
            // console.log(output);

            $(editorContent).find('*:not(td,hr)').filter(function(){
                return $.trim(this.innerHTML) === ""
            }).remove(); // Remove empty tags, which aren't TDs or HRs

            let html = cleanHtml(editorContent.html()); // Replace non-break spaces with normal spaces

            // console.log(html);
            // console.log(editorContainer.data('for'));

            // Put the formatted string back into the hidden input
            $('#' + editorContainer.data('for')).val(html);

            // window.localStorage.removeItem('autoSave-' + name + '-' + id);
        });
        // event.preventDefault();
        // return false;
    });
});

// var darkMode = console.log(getCookie('darkMode'));

let mcePlugins = 'advlist autosave autolink autoresize lists link image code fullscreen print preview anchor paste hr'
    + ' wordcount table searchreplace help tagmentions';
let mceMenu = {
    view: {title: 'View', items: 'code fullscreen'},
    insert: {title: 'Insert', items: 'bullist numlist link hr inserttable'},
    format: {
        title: 'Format',
        items: 'bold italic underline strikethrough superscript subscript | outdent indent blockquote | removeformat'
    },
    table: {title: 'Table', items: 'inserttable | cell row column | deletetable'},
};
let mceMenubar = 'edit view insert format table';

var mceConfig = {
    selector: '.textarea-editor-content',
    plugins: mcePlugins,
    autoresize_bottom_margin: 100,
    branding: false,
    browser_spellcheck: true,
    // content_css: [
    //     '/css/mce.css'
    // ],
    force_br_newlines: true,
    formats: {
        underline: {inline: 'u'/*, 'classes' : 'underline'*/, exact: true},
        strikethrough: {inline: 'strike', exact: true},
        strike: {inline: 'strike', exact: true},
    },
    invalid_elements: 'br',
    invalid_children: 'br',
    menu: mceMenu,
    menubar: mceMenubar,
    min_height: 300,
    mobile: {
        plugins: mcePlugins,
        content_css: [],
        menu: mceMenu,
        menubar: mceMenubar,
        toolbar: false,
    },
    setup: function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
        });

        editor.on('load', function () {
        let enable = getCookie('darkMode') === '1';
            let $body = tinymce.activeEditor.dom.select('body');
            if (enable) {
                tinymce.activeEditor.dom.addClass($body, 'dark-mode');
            } else {
                tinymce.activeEditor.dom.removeClass($body, 'dark-mode');
            }
        });
    },
    tag_mentions_config: {
        source: '/api/v1/tag-mentions'
    },
    skin: 'combine',
    toolbar: false,
    toolbar_sticky: true,
    toolbar_mode: 'sliding',
};

tinymce.init(mceConfig);

let setDarkModeOnEditorBody = function (enable) {
    let $body = $('iframe').contents().find('body');
    if (enable) {
        $($body).addClass('dark-mode');
    } else {
        $($body).removeClass('dark-mode');
    }
}

jQuery(function ($) {
    $('#switch-dark-mode').on('change', function () {
        let enabled = getCookie('darkMode');
        let useDarkSkin = enabled === '1';
        setDarkModeOnEditorBody(useDarkSkin);
    });
});


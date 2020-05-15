// var darkMode = console.log(getCookie('darkMode'));

let mcePlugins = 'advlist autosave autolink autoresize lists link image code fullscreen print preview anchor paste hr'
    + ' wordcount table searchreplace help';
let mceMenu = {
    file: {title: 'File', items: 'restoredraft print'},
    edit: {title: 'Edit', items: 'undo redo | cut copy paste | searchreplace'},
    view: {title: 'View', items: 'code fullscreen'},
    insert: {title: 'Insert', items: 'bullist numlist image link hr inserttable'},
    format: {
        title: 'Format',
        items: 'bold italic underline strikethrough superscript subscript | outdent indent blockquote align | removeformat'
    },
    tools: {title: 'Tools', items: 'spellchecker'},
    table: {title: 'Table', items: 'inserttable | cell row column | deletetable'},
};
let mceMenubar = 'file edit view insert format tools table';

var mceConfig = {
    selector: '.textarea-editor-content',
    plugins: mcePlugins,
    autoresize_bottom_margin: 100,
    branding: false,
    browser_spellcheck: true,
    content_css: [
        '/css/mce.css'
    ],
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

        // editor.ui.registry.addMenuItem('darkModeMenuItem', {
        //     text: 'Dark mode',
        //     onAction: function () {
        //         tinymce.DOM.toggleClass('dark-mode');
        //         tinymce.settings.body_class += 'dark-mode';
        //     }
        // });
    },
    toolbar: false,
    toolbar_sticky: true,
    toolbar_mode: 'sliding',
};

if (getCookie('darkMode') == 1) {
    mceConfig.skin  = 'charcoal';
    let darkModeCss = '/css/mce-dark.css?' + new Date().getTime();
    mceConfig.content_css.push(
        darkModeCss
    );
    mceConfig.mobile.content_css.push(
        darkModeCss
    );
}

tinymce.init(mceConfig);
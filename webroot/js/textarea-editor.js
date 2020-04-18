// var darkMode = console.log(getCookie('darkMode'));

var mceConfig = {
    // autoresize_bottom_margin: 15,
    autoresize_bottom_margin: 200,
    // autoresize_max_height: 200,
    branding: false,
    browser_spellcheck: true,
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '/css/mce.css?' + new Date().getTime()
    ],
    force_br_newlines : true,
    formats: {
        underline: {inline : 'u'/*, 'classes' : 'underline'*/, exact : true},
        strikethrough: {inline : 'strike', exact: true},
        strike: {inline : 'strike', exact: true},
    },
    invalid_elements : 'br',
    invalid_children : 'br',
    menubar: false,
    mobile: {
        content_css: [],
        theme: 'mobile',
        plugins: [
            'advlist',
        ],
        toolbar: ['undo', 'redo', 'bold', 'italic', 'underline', 'strikethrough', 'bulllist', 'numlist', 'outdent', 'indent'],
    },
    plugins: [
        'advlist autosave autolink autoresize lists link image charmap print preview anchor textcolor legacyoutput',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code help wordcount',
        'print preview searchreplace autolink directionality visualblocks visualchars template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help'
    ],
    selector: '.textarea-editor-content',
    setup: function(editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
        });
    },
    // toolbar: 'insert | undo redo | formatselect | bold italic underline strikethrough | table | bullist numlist outdent indent | removeformat | help',
    toolbar: 'undo redo | bold italic underline strikethrough | bullist numlist | outdent indent blockquote | hr | table | removeformat | fullscreen autoresize | restoredraft | code',
};

if (getCookie('darkMode') == 1) {
    mceConfig.skin = 'charcoal';
    let darkModeCss = '/css/mce-dark.css?' + new Date().getTime();
    mceConfig.content_css.push(
        darkModeCss
    );
    mceConfig.mobile.content_css.push (
        darkModeCss
    );
}

tinymce.init(mceConfig);
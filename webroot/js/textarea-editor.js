// var darkMode = console.log(getCookie('darkMode'));

var mceConfig = {
    branding: false,
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '/css/mce.css?' + new Date().getTime()
    ],
    formats: {
        underline: {inline : 'u'/*, 'classes' : 'underline'*/, exact : true},
        strikethrough: {inline : 'strike', exact: true},
        strike: {inline : 'strike', exact: true},
    },
    menubar: false,
    mobile: {
        theme: 'mobile',
        plugins: [
            'autosave', 'advlist',
        ],
        toolbar: ['undo', 'redo', 'bold', 'italic', 'underline', 'strikethrough', 'bulllist', 'numlist', 'outdent', 'indent', 'autosave'],
    },
    plugins: [
        'advlist autosave autolink lists link image charmap print preview anchor textcolor legacyoutput',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code help wordcount',
        'print preview searchreplace autolink directionality visualblocks visualchars template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help'
    ],
    selector: '.textarea-editor-content',
    // toolbar: 'insert | undo redo | formatselect | bold italic underline strikethrough | table | bullist numlist outdent indent | removeformat | help',
    toolbar: 'undo redo | bold italic underline strikethrough | bullist numlist | outdent indent | hr | table | removeformat | fullscreen | restoredraft | code',
    force_br_newlines : true,
    invalid_elements : 'br',
    invalid_children : 'br',
    setup: function(editor) {
        editor.on('keyup', function (e) {
            console.log(editor.getContent());
        });
    },
};

if (getCookie('darkMode') == 1) {
    mceConfig.skin = 'charcoal';
    let darkModeCss = '//localhost:8888/css/mce-dark.css?' + new Date().getTime();
    mceConfig.content_css.push(
        darkModeCss
    );
    mceConfig.mobile.content_css.push (
        darkModeCss
    );
}

tinymce.init(mceConfig);

$(function() {
    $('form').on('submit', function (e) {
        e.preventDefault();
        return false;
    });
});
// var darkMode = console.log(getCookie('darkMode'));

tinymce.init({
    branding: false,
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//localhost:8888/css/mce.css?' + new Date().getTime(),
        // '//localhost:8888/js/libs/tinymce/skins/default-light/content.min.css?' + new Date().getTime(),
    ],
    menubar: false,
    plugins: [
        'advlist autosave autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code help wordcount',
        'print preview searchreplace autolink directionality visualblocks visualchars template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help'
    ],
    selector: '.textarea-editor',
    skin: 'default-light',
    // toolbar: 'insert | undo redo | formatselect | bold italic underline strikethrough | table | bullist numlist outdent indent | removeformat | help',
    toolbar: 'undo redo | bold italic underline strikethrough | bullist numlist | outdent indent | hr | table | removeformat | fullscreen | restoredraft | code',
    force_br_newlines : true,
    invalid_elements : 'br',
    // setup: function(editor) {
    //     editor.on('init', function () {
    //         console.log('init');
    //         if (darkMode) {
    //             $(editor.getBody()).addClass('dark-mode');
    //         } else {
    //             $(editor.getBody()).removeClass('dark-mode');
    //         }
    //     });
    // }
});
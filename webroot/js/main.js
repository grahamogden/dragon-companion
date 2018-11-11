jQuery(document).ready(function($) {
    let backgroundImages = [{
            url: 'battle_of_four_armies_by_jasonengle.jpg',
            slcted: true,
        },
        {
            url: '190622ddba35c1efab03fec90b427c65-d7pdb8i.png',
            slcted: false,
        },
        {
            url: 'commission__dungeons_and_dragons_party_by_kiralng-dbu4089.png',
            slcted: false,
        },
        {
            url: 'dungeons_and_dragons__minimalistic_party_wallpaper_by_conanultimate-d99abng.jpg',
            slcted: false,
        },
        {
            url: 'dungeons_and_dragons_party_by_uncannyknack-d7j7l0r.jpg',
            slcted: false,
        },
        {
            url: 'fantasy_asian_by_macduykhanh121094-da50lyq.jpg',
            slcted: false,
        },
    ];

    let transitionTime = 200; // 0.2 seconds
    let intervalTime = 7000; // 7 seconds

    let setCookie = function(key, value) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (365 * 24 * 60 * 60 * 1000));
        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }

    let getCookie = function(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
    }

    /**
     * Retrieves the currently selected header background image
     * 
     * @return object
     */
    let getSelectedBackgroundImage = function() {
        let image;
        let i = 0;
        do {
            image = backgroundImages[i];
            i++;
        } while (image.slcted === false);
        return image;
    }

    /**
     * Randomly selects and image from the array and returns image file name and file type
     * 
     * @return string
     */
    let pickBackgroundImage = function() {
        let image;
        do {
            image = backgroundImages[Math.floor(Math.random() * backgroundImages.length)]
        } while (image.slcted === true);

        currentImage = getSelectedBackgroundImage();
        currentImage.slcted = false;
        image.slcted = true;

        return image.url;
    }

    /**
     * Switches out the background image of the header for a random one from the array
     * 
     * @param  object backgroundHeader 
     * @return void
     */
    let changeBackgroundImage = function(backgroundHeader) {
        url = pickBackgroundImage();

        backgroundHeader.css({
            "background-image": "url('/img/backgrounds/" + url + "')"
        });
    }

    /**
     * Adds the animation CSS property and then sets the interval to replace the background image
     */
    let backgroundSlider = function() {
        let backgroundHeader = $("#header-background");

        backgroundHeader.css({
            animation: "move-header-mobile " + (intervalTime / 1000) + "s linear infinite",
        });

        setInterval(function() {
            changeBackgroundImage($("#header-background"))
        }, intervalTime);
    }

    /**
     * Turns on or off the dark mode
     * @param bool isEnabled
     */
    let setDarkMode = function(isEnabled = false) {
        if (isEnabled === true) {
            window.localStorage.darkMode = 1;
            setCookie('darkMode', 1);
            $('body').addClass('dark-mode');
            $('#switch-dark-mode').prop('checked', true);
        } else {
            window.localStorage.removeItem('darkMode');
            setCookie('darkMode', 0);
            $('body').removeClass('dark-mode');
            $('#switch-dark-mode').prop('checked', false);
        }
    }

    /**
     * Toggles the header images to animate - currently only enables, cannot disable
     * @return void
     */
    let toggleHeaderSlider = function() {
        backgroundSlider();
    }

    // $('#top-bar').click(function() {
    //     url = pickBackgroundImage();

    //     $("#header-background").css({
    //         "background-image": "url('/img/backgrounds/" + url + "')"
    //     });
    // });

    // backgroundSlider();

    $('#switch-header-slider').click(function() {
        toggleHeaderSlider();
    });

    $('.menu-button').click(function() {
        $(this).parent().toggleClass('open');
        $(this).siblings('ul').slideToggle(transitionTime);
    });

    $('#nav-menu-button').click(function() {
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

    // setDarkMode(getCookie('darkMode'));

    $('#switch-dark-mode').on('change', function() {
        let isChecked = $(this).is(':checked');
        // console.log(isChecked);
        setDarkMode(isChecked);
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

    // tinymce.init({
    //     menubar: false,
    //     plugins: [
    //         'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'print', 'preview', 'hr', 'anchor', 'spellchecker',
    //         'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime', 'nonbreaking',
    //         'autosave', 'table', 'contextmenu', 'directionality', 'emoticons', 'paste', 'textcolor'
    //     ],
    //     selector: '.textarea-editor',
    //     skin: 'default',
    //     statusbar: false,
    //     toolbar: 'undo redo | styleselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview | restoredraft code'
    // });

    var options = {
        debug: 'error',
        // modules: {
        //     toolbar: '#toolbar'
        // },
        modules: {
            toolbar: [
                [{ header: [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block']
            ]
        },
        scrollingContainer: '.textarea-editor-2-content',
        placeholder: 'Compose an epic...',
        theme: 'snow'
    };
    var editor = new Quill('.textarea-editor-2-content', options); // First matching element will be used
});

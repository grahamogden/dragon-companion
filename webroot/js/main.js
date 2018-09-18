jQuery(document).ready(function($) {
    let backgroundImages = [
        'battle_of_four_armies_by_jasonengle.jpg',
        '190622ddba35c1efab03fec90b427c65-d7pdb8i.png',
        'commission__dungeons_and_dragons_party_by_kiralng-dbu4089.png',
        'dungeons_and_dragons__minimalistic_party_wallpaper_by_conanultimate-d99abng.jpg',
        'dungeons_and_dragons_party_by_uncannyknack-d7j7l0r.jpg',
        'fantasy_asian_by_macduykhanh121094-da50lyq.jpg',
    ];

    let transitionTime = 200; // 0.2 seconds
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
        let backgroundHeader = $("#header-background");

        backgroundHeader.css({
            animation: "move-header-mobile " + (intervalTime / 1000) + "s linear infinite",
        });

        // backgroundHeader.addClass('animate');

        let url = '';

        setInterval(function() {
            let currentUrl = backgroundHeader.css('background-image');
            url = pickBackgroundImage(currentUrl);

            backgroundHeader.css({
                "background-image": "url('/img/backgrounds/" + url + "')"
            });
        }, intervalTime);
    }

    // backgroundSlider();

    $('.menu-button').click(function(){
        $(this).parent().toggleClass('open');
        $(this).siblings('ul').slideToggle(transitionTime);
    });

    $('#nav-menu-button').click(function(){
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

    let setDarkMode = function(isEnabled = false) {
        if (isEnabled === true) {
            console.log('enabling dark mode');
            window.localStorage.darkMode = 'true';
            $('body').addClass('dark-mode');
            $('#switch-color-scheme').prop('checked', true);
        } else {
            console.log('disabling dark mode');
            window.localStorage.removeItem('darkMode');
            $('body').removeClass('dark-mode');
            $('#switch-color-scheme').prop('checked', false);
        }
    }

    $('#switch-color-scheme').on('change', function() {
        let isChecked = $(this).is(':checked');
        console.log(isChecked);
        setDarkMode(isChecked);
    });

    setDarkMode(window.localStorage.darkMode === 'true');

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
    
    
});
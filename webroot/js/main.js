$(function() {
    let backgroundImages = [
        "battle_of_four_armies_by_jasonengle.jpg",
        "190622ddba35c1efab03fec90b427c65-d7pdb8i.png",
        "commission__dungeons_and_dragons_party_by_kiralng-dbu4089.png",
        "dungeons_and_dragons__minimalistic_party_wallpaper_by_conanultimate-d99abng.jpg",
        "dungeons_and_dragons_party_by_uncannyknack-d7j7l0r.jpg",
        "fantasy_asian_by_macduykhanh121094-da50lyq.jpg",
    ];

    let intervalTime = 7000; // 7 seconds

    // let headerbackgroundChange = function (url) {
    //     let headerImage = $("#header-background");
    //     headerImage.css({
    //             "background-image": "url('/img/backgrounds/" + url + "')",
    //             // "background-position": "50% 40%",
    //             backgroundPositionY: "40%",
    //         })
    //     console.log(headerImage['style']['background-position-y']);

    //     let timeout = 100;
    //     setTimeout(function () {
    //         console.log(headerImage['style']['background-position-y']);
    //         headerImage.animate({
    //             // backgroundPositionX: "50%",
    //             backgroundPositionY: "60%",
    //         }, intervalTime - timeout, "linear");
    //         console.log(headerImage['style']['background-position-y']);
    //     }, timeout);
    // }

    /**
     * Randomly selects and image from the array and returns the string
     */
    let pickBackgroundImage = function (currentUrl) {
        // let returnUrl = '';
        // console.log('----------------------------------------------------------');
        // console.log('Current: ' + currentUrl);
        // do {
            returnUrl = backgroundImages[Math.floor(Math.random()*backgroundImages.length)];
            // console.log('Return: ' + returnUrl);
        //     console.log(returnUrl.indexOf(currentUrl) >= 0);
        // } while (returnUrl.indexOf(currentUrl) >= 0);
        // console.log('Using: ' + returnUrl)
        return returnUrl;
    }

    /**
     * Adds the animation CSS property and then sets the interval to replace the background image
     */
    let backgroundSlider = function() {
        var backgroundHeader = $("#header-background");

        backgroundHeader.css({
            animation: "move-header-mobile " + (intervalTime / 1000) + "s linear infinite",
        });

        // backgroundHeader.addClass('animate');

        var url = '';

        setInterval(function() {
            let currentUrl = backgroundHeader.css('background-image');
            url = pickBackgroundImage(currentUrl);

            backgroundHeader.css({
                "background-image": "url('/img/backgrounds/" + url + "')"
            });
        }, intervalTime);
    }

    // backgroundSlider();

    $('#nav-menu-button').click(function(){
        $('header nav').toggleClass('open');
        $(this).toggleClass('open');
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
});
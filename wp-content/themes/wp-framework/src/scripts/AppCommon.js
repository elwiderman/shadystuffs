/* 
**  All the common js methods are called here
*/
import fancybox from '@fancyapps/fancybox';

export default class AppCommon {
    constructor() {
        this.init();
    }

    // init the class
    init() {
        this.pageLoading();
        this.goTop();
        this.nav();
        this.fancyLightbox();
        this.postGallery();
    }

    // page loading anim
    pageLoading() {
        /* Loader for page */
        $(window)
            .on('load', function () {
                $('.spinner').delay(300).fadeOut();
                $('.animationload').delay(600).fadeOut('slow');
            })
            .on('beforeunload', function () {
                // turn the spinner back on before unload
                $('.spinner').fadeIn();
                $('.animationload').fadeIn();
            });
    }

    // go to top of the page action
    goTop() {
        $(window).scroll(function () {
            var scroll = $(window).scrollTop();

            if (scroll >= 400) {
                $('.go-top').addClass('show');
            } else {
                $('.go-top').removeClass('show');
            }
        });

        $('.go-top').click(function (e) {
            e.preventDefault();

            $('html, body').animate({
                scrollTop: $('html, body').offset().top
            }, 1000);
        });
    }
    
    // all actions for the main nav
    nav() {
        // if ($(window).width() > 1023) {
        //     $('.navbar-collapse .dropdown').hover(function () {
        //         $(this).toggleClass('show').find(' > .dropdown-menu').toggleClass('show');
        //     });
        //     $('.navbar-collapse .dropdown').click(function (e) {
        //         e.stopPropagation();
        //     });
        // }
        // // if there is a link then go to link
        // $('.navbar-collapse .dropdown > a').click(function () {
        //     location.href = this.href;
        // });

        // toggle off-canvas menu
        // $('.header').find('.navbar-toggler').click(function () {
        //     $('body').toggleClass('no-overflow').children('.no-overflow').toggleClass('show');
        // });
        // $('body .no-overflow').click(function () {
        //     $('header .navbar-toggler').trigger('click');
        // });


        $('.header').on('click', '.navbar-toggler', e => {
            e.preventDefault();

            console.log(e);
            $(e.currentTarget).toggleClass('open');
        });
    }

    // refresh the page if its resizing
    refreshIfMobile() {
        window.resize(() => {
            setTimeout(() => {
                location.reload();
            }, 100);
        });
    }

    // trigger the fancybox 
    fancyLightbox() {
        $('.wp-block-gallery').each((i, elem) => {
            let target = $(elem).find('.blocks-gallery-item > figure > a');

            target.attr('data-fancybox', `gallery-${i}`);

            target.fancybox();
        });
    }

    // common carousel for posts
    postGallery() {
        $('.gallery-section .gallery-carousel').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
        });
    }
}
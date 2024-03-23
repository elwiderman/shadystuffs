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
        // this.pageLoading();
        this.goTop();
        this.nav();
        this.fancyLightbox();
        this.postGallery();
        this.sizeChartTrigger();

        if ($('#mobiSidebar').length) {
            this.sidebarToggle();
        }
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
        const navToggler    = $('.header .navbar-toggler'),
            mainWrap        = $('.main-content-wrap'),
            offCanvasMenu   = $('.header .header__main-menu');

        $('.header').on('click', '.navbar-toggler', e => {
            e.preventDefault();
            $(e.currentTarget).toggleClass('open');
            mainWrap.toggleClass('menu-open');
            offCanvasMenu.toggleClass('open');
            $('body').toggleClass('no-overflow');
        });

        $('body').find('.no-overflow').on('click', e => {
            e.preventDefault();
            e.stopPropagation();

            navToggler.removeClass('open');
            offCanvasMenu.removeClass('open');
            mainWrap.removeClass('menu-open');
            $('body').removeClass('no-overflow');
        });

        $('header.header .dropdown').on('click', 'a.dropdown-toggle', e => {
            e.preventDefault();
            e.stopPropagation();
            if ($(e.currentTarget).attr('href') != '#') {
                location.href = $(e.currentTarget).attr('href');
            }
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

    // trigger the size chart modal
    sizeChartTrigger() {
        if ($('#sizeChartPop').length) {
            $(document).on('click', 'a', e => {
                if ($(e.currentTarget).attr('href') === '#sizeChartPop') {
                    e.preventDefault();
                    // trigger the modal
                    $('#sizeChartPop').modal('show');
                }
            });
        }
    }

    // do the toggle for the sidebar 
    sidebarToggle() {
        // remove filter off canvas open if more than mobile 
        $(window).on('load resize', e => {
            if ($(window).width() > 768) {
                $('#mobiSidebar, #filterToggle').removeClass('open');
                $('body').removeClass('no-overflow');
            }
        });

        // do the toggle magic
        $('#filterToggle').on('click', e => {
            let $this = $(e.currentTarget),
                target = $this.data('target');

            if ($this.hasClass('open')) {
                $this.removeClass('open');
                $(target).removeClass('open');
                $('body').removeClass('no-overflow');
            } else {
                $this.addClass('open');
                $(target).addClass('open');
                $('body').addClass('no-overflow');
            }
        });
    }
}
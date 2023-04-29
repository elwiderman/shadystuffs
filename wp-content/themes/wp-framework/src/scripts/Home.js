/* 
** All the home js methods are called here
*/
// since the following package doesnt have package.json, cannot import using npm
import browser from 'browser-detect';

// get the browser info
const browserInfo = browser();

export default class Home {
    constructor() {

    }

    // init the class
    init() {
        this.slider();
    }

    slider() {
        let $this = this;
        const slider = $('.home-slider');
        let dotsWrapOuter = $('.home-slider + .appended-dots'),
            dotsWrapper = dotsWrapOuter.find('.dots-wrap');

        // animate on init
        slider.on('init', function (e, slick) {
            let elem = $(slick.$slides[0]).find('[data-animation]');
            $this.animateSlide(elem);
        });

        let autoplaySpeed = 5000;

        $(window).on('load', () => {
            // home page slider
            $('.home-slider').slick({
                dots: true,
                arrows: false,
                infinite: true,
                speed: 500,
                fade: true,
                cssEase: 'ease',
                autoplay: true,
                autoplaySpeed: autoplaySpeed,
                lazyLoad: 'ondemand',
                pauseOnHover: false,
                // appendDots: dotsWrapper
            });
        });

        slider.on('beforeChange', function (e, slick, currentSlide, nextSlide) {
            let elem = $('.home-slider .slick-slide[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
            $this.animateSlide(elem);
        });
    }

    animateSlide(elem) {
        let animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        elem.each(function () {
            let t = $(this);
            let animationDelay = t.data('delay');
            let animationType = 'animated ' + t.data('animation');
            t.css({
                'animation-delay': animationDelay,
                '-webkit-animation-delay': animationDelay
            });
            t.addClass(animationType).one(animationEndEvents, () => {
                t.removeClass(animationType);
            });
        });
    }
}
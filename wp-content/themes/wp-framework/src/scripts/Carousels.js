export default class Carousels {
    constructor() {
        this.init();
    }

    init() {
        if ($('.single-page.single-home').length) {
            this.homeHero();
        }

        if ($('.products-carousel').length || $('#crossSells').length) {
            this.productCarousels();
        }

        if ($('#productSingleCarouselMain').length) {
            this.productSingleCarousel();
        }
    }

    homeHero() {
        $('.hero-slider').slick({
            dots: true,
            arrows: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 5000,
            rows: 0,
            speed: 800,
            fade: false,
            cssEase: 'ease',
            lazyLoad: 'ondemand',
            pauseOnHover: true,
        });
    }

    productCarousels() {
        $('.products-carousel').each((i, elem) => {
            $(elem).slick({
                dots: true,
                arrows: false,
                infinite: true,
                speed: 800,
                fade: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                swipeToSlide: true,
                waitForAnimate: false,
                centerMode: false,
                lazyLoad: 'ondemand',
                adaptiveHeight: false,
                variableWidth: true,
                autoplay: true,
                autoplaySpeed: 4000,
                pauseOnHover: true,
                rows: 0,
            });
        });
    }

    productSingleCarousel() {
        $('#productSingleCarouselMain').slick({
            dots: false,
            arrows: false,
            infinite: true,
            autoplay: false,
            rows: 0,
            speed: 800,
            fade: true,
            cssEase: 'ease',
            lazyLoad: 'ondemand',
            asNavFor: '#productSingleCarouselNav'
        });

        $('#productSingleCarouselNav').slick({
            dots: false,
            arrows: true,
            infinite: true,
            autoplay: false,
            rows: 0,
            speed: 800,
            fade: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            vertical: true,
            centerMode: false,
            focusOnSelect: true,
            cssEase: 'ease',
            lazyLoad: 'ondemand',
            asNavFor: '#productSingleCarouselMain',
            prevArrow: '<button class="slick-prev slick-arrow"><i class="icon-chevron-up"></i></button>',
            nextArrow: '<button class="slick-next slick-arrow"><i class="icon-chevron-down"></i></button>',
            responsive: [{
                breakpoint: 768,
                settings: {
                    speed: 800,
                    infinite: true,
                    centerMode: false,
                    variableWidth: true,
                    adaptiveHeight: true,
                    vertical: false,
                }
            }]
        });
    }
}
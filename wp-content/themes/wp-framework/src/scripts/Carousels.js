export default class Carousels {
    constructor() {
        this.init();
    }

    init() {
        if ($('.single-page.single-home').length) {
            this.homeHero();
        }

        if ($('.products-carousel').length) {
            this.productCarousels();
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
}
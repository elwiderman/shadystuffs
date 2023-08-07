export default class Carousels {
    constructor() {
        this.init();
    }

    init() {
        if ($('.single-page.single-home').length) {
            this.homeHero();
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
}
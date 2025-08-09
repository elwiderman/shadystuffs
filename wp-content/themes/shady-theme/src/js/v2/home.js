import ready from 'domready';
import $ from 'jquery';
// import 'slick-carousel';
import Swiper from 'swiper';
import { Navigation, Pagination, Mousewheel, Autoplay } from 'swiper/modules';

export default class Home {
    constructor() {
        this.init();
    }

    init() {
        this.heroSlider();
    }

    heroSlider() {
        const swiper = new Swiper('#homeHeroSlider', {
            modules: [Autoplay, Mousewheel],
            autoplay: {
                delay: 5000,
                pauseOnMouseEnter: true,
            },
            loop: true,
            loopedSlides: 5,
            loopAdditionalSlides: 5,
            mousewheel: true,
            slidesPerView: 5,
            spaceBetween: 0,
        });
    }
}

ready(() => {
    new Home();
});
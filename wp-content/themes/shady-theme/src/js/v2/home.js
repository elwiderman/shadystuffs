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
        this.collectionsSlider();
        this.bestsellersSlider();
    }

    heroSlider() {
        const swiper = new Swiper('#homeHeroSlider', {
            modules: [Autoplay, Mousewheel],
            autoplay: {
                delay: 5000,
                pauseOnMouseEnter: true,
            },
            navigation: false,
            loop: true,
            loopedSlides: 5,
            loopAdditionalSlides: 5,
            mousewheel: {
                forceToAxis: true
            },
            slidesPerView: 5,
            spaceBetween: 0,
            freeMode: true
        });
    }

    collectionsSlider() {
        const swiper = new Swiper('#homeCollectionsSlider', {
            modules: [Autoplay, Navigation,],
            autoplay: {
                delay: 5000,
                pauseOnMouseEnter: true,
            },
            loop: true,
            loopedSlides: 5,
            slidesPerView: 1,
            spaceBetween: 0,
            navigation: {
                nextEl: '.left-arrow',
                prevEl: '.right-arrow',
            },
        });
    }

    bestsellersSlider() {
        const swiper = new Swiper('#bestsellersSlider', {
            modules: [Autoplay, Navigation, Mousewheel],
            autoplay: {
                delay: 5000,
                pauseOnMouseEnter: true,
            },
            loop: true,
            loopedSlides: 4,
            slidesPerView: 4,
            spaceBetween: '24px',
            mousewheel: {
                forceToAxis: true
            },
            navigation: {
                nextEl: '.left-arrow',
                prevEl: '.right-arrow',
            },
        });
    }
}

ready(() => {
    new Home();
});
import $ from 'jquery';
import 'slick-carousel';
import gsap from 'gsap';

export default class Carousels {
    constructor() {
        this.init();
    }

    init() {
        if ($('.single-page.single-home').length) {
            this.homeHero();
            this.homeHeroV2();
            this.bestSellerCarousels();
        }

        if ($('.products-carousel').length || $('#crossSells').length) {
            this.productCarousels();
        }

        if ($('#productSingleCarouselMain').length) {
            this.productSingleCarousel();
        }

        if ($('#highlightOfferSlider').length) {
            this.prodSingleOfferSlider();
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

    homeHeroV2() {
        let slider = $('.home-hero-slider');

        slider.on('init', (evt, slick) => {
            let slide = $(slider).find('.slick-current.slick-active'),
                thumb = slide.find('.slide__thumb'),
                animItems = gsap.utils.toArray(slide.find('.to-stagger'));

            let tl = gsap.timeline();
            tl.from(thumb, {
                autoAlpha: 0,
                xPercent: 50,
                duration: 0.5
            }, '+=0.6').from(animItems, {
                autoAlpha: 0,
                xPercent: -20,
                stagger: 0.3,
            });
        });

        slider.slick({
            dots: true,
            arrows: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 5000,
            rows: 0,
            speed: 800,
            fade: true,
            cssEase: 'ease',
            lazyLoad: 'ondemand',
            pauseOnHover: true,
        });

        slider.on('beforeChange', (evt, slick, currentSlide, nextSlide) => {            
            let slide = slick.$slides[nextSlide],
                thumb = $(slide).find('.slide__thumb'),
                animItems = gsap.utils.toArray($(slide).find('.to-stagger'));

            let tl = gsap.timeline();
            tl.from(thumb, {
                autoAlpha: 0,
                xPercent: 50,
                duration: 0.5
            }, '+=0.6').from(animItems, {
                autoAlpha: 0,
                xPercent: -20,
                stagger: 0.3,
            });
        });
    }

    bestSellerCarousels() {
        $('.bestsellers-carousel').slick({
            dots: false,
            arrows: false,
            infinite: true,
            speed: 800,
            fade: false,
            slidesToShow: 5,
            slidesToScroll: 1,
            swipeToSlide: true,
            // waitForAnimate: true,
            centerMode: false,
            lazyLoad: 'ondemand',
            adaptiveHeight: false,
            variableWidth: false,
            autoplay: true,
            autoplaySpeed: 4000,
            pauseOnHover: true,
            rows: 0,
            responsive: [
                {
                    breakpoint: 1500,
                    settings: {
                        slidesToShow: 4,
                    }
                }, {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                    }
                }, {
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 1,
                        pauseOnHover: false,
                        centerMode: true,
                    }
                }
            ]
        });
    }

    productCarousels() {
        $('.products-carousel').each((i, elem) => {
            $(elem).slick({
                dots: false,
                arrows: false,
                infinite: true,
                speed: 800,
                fade: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                swipeToSlide: true,
                waitForAnimate: true,
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
            autoplay: true,
            rows: 0,
            speed: 800,
            fade: true,
            cssEase: 'ease',
            lazyLoad: 'ondemand',
            asNavFor: '#productSingleCarouselNav',
            adaptiveHeight: true,
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
            variableWidth: false,
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


        let mainSlider = $('#productSingleCarouselMain'),
            navSlider = $('#productSingleCarouselNav'),
            parent = mainSlider.parents('.product-img-wrap');

        $(window).on('load resize', e => {
            if ($(window).width() > 767) {
                mainSlider.css({
                    'width': parent.width() - navSlider.width() - 20
                });
            } else {
                mainSlider.css({
                    'width': parent.width()
                });
            }
        });
    }

    prodSingleOfferSlider() {
        $('#highlightOfferSlider').slick({
            dots: false,
            arrows: true,
            infinite: false,
            speed: 800,
            fade: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            centerMode: false,
            lazyLoad: 'ondemand',
            adaptiveHeight: false,
            variableWidth: true,
            autoplay: false,
            rows: 0,
            prevArrow: '<button class="slick-prev slick-arrow"><i class="icon-chevron-left"></i></button>',
            nextArrow: '<button class="slick-next slick-arrow"><i class="icon-chevron-right"></i></button>',
        });
    }
}
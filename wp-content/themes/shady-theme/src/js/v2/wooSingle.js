import ready from 'domready';
import $ from 'jquery';
import Swiper from 'swiper';
import { Navigation, Pagination, Mousewheel, Autoplay, FreeMode } from 'swiper/modules';
import { Fancybox } from "@fancyapps/ui";
import * as bootstrap from 'bootstrap';
import 'simplebar';

export default class Home {
    constructor() {
        this.init();
    }

    init() {
        // let form = $('.variations_form');
        // console.log(form.data('product_variations'));
                
        this.discountSlider();
        this.productSlider();
        this.fancyboxInit();
        this.theQuantityButtons();
        this.moveSizechartBtn();
    }

    discountSlider() {
        const swiper = new Swiper('#highlightOfferSlider', {
            modules: [Autoplay, Navigation, Mousewheel, FreeMode],
            autoplay: {
                delay: 5000,
                pauseOnMouseEnter: true,
            },
            loop: true,
            loopedSlides: 5,
            slidesPerView: 'auto',
            spaceBetween: 12,
            mousewheel: {
                forceToAxis: true
            },
            navigation: false,
            freeMode: true
        });
    }

    productSlider() {
        $('.products-slider').each((i, elem) => {
            let swiper = new Swiper(elem, {
                modules: [Autoplay, Navigation, Mousewheel, FreeMode],
                autoplay: {
                    delay: 5000,
                    pauseOnMouseEnter: true,
                },
                loop: true,
                loopedSlides: 5,
                slidesPerView: 5,
                spaceBetween: '24px',
                mousewheel: {
                    forceToAxis: true
                },
                navigation: {
                    nextEl: '.left-arrow',
                    prevEl: '.right-arrow',
                },
                freeMode: true
            });
        });
    }

    // show fancybox
    fancyboxInit() {
        Fancybox.bind("[data-fancybox]", {
            // Options will go here
            Thumbs: false,
            Toolbar: false,
            Image: {
                zoom: true,
                clickToClose: true,
                wheel: false
            },
        });
    }

    // updates the product quantity on click of the plus minus buttons
    theQuantityButtons() {
        $(document).find('.quantity').on('click', 'button.plus, button.minus', (e) => {
            let $this = $(e.currentTarget),
                qty = $this.parent('.quantity').find('.qty'),
                val = parseFloat(qty.val()),
                max = parseFloat(qty.attr('max')),
                min = parseFloat(qty.attr('min')),
                step = parseFloat(qty.attr('step'));

            if ($this.is('.plus')) {
                if (max && (max <= val)) {
                    qty.val(max).trigger('change');
                } else {
                    qty.val(val + step).trigger('change');
                }
            } else {
                if (min && (min >= val)) {
                    qty.val(min).trigger('change');
                } else if (val > 1) {
                    qty.val(val - step).trigger('change');
                }
            }
        });
    }

    moveSizechartBtn() {
        let guidesObj = [
            {
                trigger: $('.sizechart-wrap__trigger-sizechart'),
                label: 'pa_size'
            }, {
                trigger: $('.fabricguide-wrap__trigger-fabricguide'),
                label: 'pa_fabric'
            }
        ];

        guidesObj.forEach(elem => {
            this.moveCustomGuideModalsAroundVariations(elem.trigger, elem.label);
        });
    }
    
    // this is to move the custom guide modal trigges to be on the sides of the appropriate variation label
    moveCustomGuideModalsAroundVariations(trigger, labelFor) {
        if (trigger.length) {
            trigger.detach();
            let label = `label[for="${labelFor}"]`;

            $('form.variations_form .variations').find(`.wpcvs-attribute-label > ${label}`).closest('.wpcvs-attribute-label').addClass('popup-guide-appended').append(trigger);
        }
    }
}

ready(() => {
    new Home();
});
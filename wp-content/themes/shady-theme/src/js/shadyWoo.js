// all js actions for the woo pages

import $ from 'jquery';
import ready from 'domready';

export default class Woo {
    constructor() {
        this.init();
    }

    init() {
        if ($('.single-page.single-product').length) {
            this.theQuantityButtons();
            this.moveSizechartBtn();
        }
        if ($('#shadyCart').length) {
            this.theQuantityButtons();

            this.moveCrossSells();

            this.ajaxUpdateCart();

            this.removeCrossSellOnCartUpdate();
        }
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

            $('form.variations_form .variations').find(label).parents('th.label').addClass('popup-guide-appended').append(trigger);
        }
    }

    moveCrossSells() {
        let crossSell = $('#crossSells');

        if (crossSell.length) {
            crossSell.detach();

            $('#shadyCart').find('.cross-sell-wrap').append(crossSell);
        }
    }

    // update the cart info in the cart page on changing of quantity
    ajaxUpdateCart() {
        $('body').on('change', '.quantity input.qty', (e) => {
            let $this = $(e.currentTarget);
            // Get the product key (cart item key)
            // var cartItemKey = $this.attr('name').replace(/qty\[(.*?)\]/g, '$1');
            let cartItemKey = $this.attr('name').replace('[qty]', '');
            cartItemKey = cartItemKey.replace(/cart\[(.*?)\]/g, '$1');

            // Get the new quantity
            var quantity = $this.val();

            // AJAX request to update the cart
            $.ajax({
                url: WPURLS.ajaxurl,
                type: 'POST',
                data: {
                    action: 'shady_ajax_update_cart',
                    security: WPURLS.cart_nonce,
                    cart_item_key: cartItemKey,
                    quantity: quantity,
                },
                beforeSend: xhr => {
                    console.log('updating cart...');
                    $('#shadyCart').addClass('loading');
                },
                success: response => {
                    // Handle the response, e.g., update the cart totals and display messages
                    // console.log(response);

                    let cartTotalWrap = $('.cart_totals.cart-totals'),
                        cartTotalTable = cartTotalWrap.find('table.shop_table');

                    if (response.subtotal) {
                        cartTotalTable.find('tr.cart-subtotal > td').html(response.subtotal);
                    }
                    if (response.total) {
                        cartTotalTable.find('tr.order-total > td > strong').html(response.total);
                    }

                    if (response.cart_items.length > 0) {
                        response.cart_items.forEach(elem => {
                            // console.log(elem);
                            let itemTarget = $(`#key-${elem.key}`);

                            itemTarget.find('.product-subtotal__price').html(elem.subtotal);
                        });
                    }

                    $('#shadyCart').removeClass('loading');
                }
            });
        });
    }

    removeCrossSellOnCartUpdate() {
        $(document).on('wc_update_cart removed_from_cart cart_page_refreshed', e => {
            $('.woocommerce-cart-form').find('#crossSells').remove();
        });
    }
}

ready(() => {
    new Woo();
});
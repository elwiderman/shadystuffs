// all js actions for the woo pages

export default class Woo {
    constructor() {
        this.init();
    }

    init() {
        if ($('#shadyCart').length) {
            this.moveCrossSells();
            // this.ajaxUpdateCart();
        }
    }

    moveCrossSells() {
        let crossSell = $('#crossSells');

        if (crossSell.length) {
            crossSell.detach();

            $('#shadyCart').find('.cross-sell-wrap').append(crossSell);
        }
    }
    ajaxUpdateCart() {
        $('.cart-table-wrap').on('click', '.quantity .quantity__btn', e => {
            $('#updateCart').trigger('click');
            
            // let btn = $(e.currentTarget),
            //     input = btn.parents('.quantity').find('input.qty'),
            //     cartItemKey = input.attr('name'),
            //     quantity = input.val();

            // $.ajax({
            //     type: 'POST',
            //     url: WPURLS.ajax_url,
            //     data: {
            //         action: 'ajax_update_cart',
            //         security: WPURLS.cart_nonce,
            //         cart_item_key: cartItemKey,
            //         quantity: quantity,
            //     },
            //     beforeSend: xhr => {
            //         console.log('updating cart...');
            //     },
            //     success: response => {
            //         // Handle the response, e.g., update the cart totals and display messages
            //         console.log(response);
            //     }
            // });
        });

        // console.log(WPURLS);

        // $('#shadyCart').find('.quantity input').each((i, elem) => {
        //     console.log(elem);
        //     $(elem).on('change input', e => {
        //         console.log('asdass', e);
        //     })
        // });
    }
}
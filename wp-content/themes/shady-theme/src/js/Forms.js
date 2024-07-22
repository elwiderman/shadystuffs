/* all forms js methods are here */

import $ from 'jquery';
import select2 from 'select2';
//Hook up select2 to jQuery
select2($);

export default class Forms {
    constructor() {
        this.init();
    }

    init() {
        this.selectDropdown();
    }

    // select2 dropdowns
    selectDropdown() {
        // generic
        $('select.form-control').each((i, elem) => {
            let placeholder = $(elem).data('placeholder');
            // add the placeholder for the dropdown as the first option of the select if cf7 form
            if ($(elem).hasClass('wpcf7-select')) {
                placeholder = $(elem).find('option:first-child').html();
                // remove the first elem 
                $(elem).find('option:first-child').html('');
            }

            $(elem).select2({
                width: '100%',
                placeholder: placeholder,
                dropdownParent: $(elem).closest('.form-control-wrap'),
                minimumResultsForSearch: -1
            });
        });


        // woo archive page dropdown
        let orderform = $('form.woocommerce-ordering')
        orderform.find('select').select2({
            width: '100%',
            dropdownParent: $('form.woocommerce-ordering'),
            minimumResultsForSearch: -1
        });

        orderform.find('select').on('change', e => {
            orderform.trigger('submit');
        });
    }
}
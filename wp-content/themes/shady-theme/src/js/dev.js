import ready from 'domready';
import $ from 'jquery';

export default class Dev {
    constructor() {
        this.init();
    }

    init() {
        this.cleanUpTshirts();
    }

    cleanUpTshirts() {
        const form = $('#variationFix');

        form.on('submit', (e) => {
            e.preventDefault();

            let total = form.find('input[name="total"]').val(),
                found = parseInt(form.find('input[name="found_pages"]').val()),
                page = parseInt(form.find('input[name="page"]').val());

            if (page <= found) {
                $.ajax({
                    type: 'POST',
                    url: WPURLS.ajaxurl,
                    dataType: 'json',
                    data: form.serializeArray(),
                    beforeSend: () => {
                        // console.log(form.serialize());
                        console.log('loading...');
                        form.find('span').show();
                        console.log(`Page ${page} of ${found}`);
                    },
                    success: (response) => {
                        console.log(response);
                        
                        if (response) {
                            if (response.last_page === false) {
                                page = parseInt(response.page);
                                form.find('input[name="page"]').val(page);
                                form.trigger('submit');
                            } else {
                                form.find('span').hide();
                            }
                        }
                        
                    },
                    error: (xhr, status, error) => {
                        console.error('Error:', error);
                        // form.find('.result').html('An error occurred. Please try again.');
                    }
                });
            }
            return false;
        });
    }
}

ready(() => {
    // Your code here
    console.log('DOM is ready!');
    new Dev();
});

let $ = jQuery.noConflict();

if (typeof jQuery != 'undefined') {
    console.log('jQuery ', jQuery.fn.jquery);
}

import ready from 'domready';

import 'bootstrap';
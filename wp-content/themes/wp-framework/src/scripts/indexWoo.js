/*!
*   Title: Jeetlab wordpress framework
*   Description: All custom javascript overrides are here.
*   Version: 3.0.0
*   Author: Ajasra Das(ajasra@jeetlab.com)
*/

let $ = jQuery.noConflict();

if (typeof jQuery != 'undefined') {
    console.log('jQuery ', jQuery.fn.jquery);
}

import ready from 'domready';
import Woo from './Woo';

ready(() => {
    new Woo();
});
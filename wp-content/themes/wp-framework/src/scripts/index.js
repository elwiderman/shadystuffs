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

import AppCommon from './AppCommon';
import Home from './Home';

// get the libraries
import 'bootstrap';
import 'slick-carousel';
import 'simplebar';

ready(() => {
    window.appCommon = new AppCommon();
    window.appCommon.init();

    // initialize the home 
    window.home = new Home();
    window.home.init();
});
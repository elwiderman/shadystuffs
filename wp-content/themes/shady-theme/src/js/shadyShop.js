// all js actions for the woo pages

import $ from 'jquery';
import debounce from 'lodash/debounce';
import random from 'lodash/random';
import 'waypoints/lib/noframework.waypoints';

export default class ShadyShop {
    constructor() {
        this.init();
        this.canBeLoaded = true;
    }

    init() {
        this.filterForm();
        this.submitFormWithFilters();
        this.loadMore();
    }

    filterForm() {
        let form = $('#shadySidebar'),
            loadMore = $('#loadMoreProducts').parents('.load-more-wrap'),
            result = $('#resultCount'),
            objectUrl = new URL(window.location.href);

        form.on('submit', e => {
            e.preventDefault();

            let loadingWrap = $('#productGrid').siblings('.product-wrap__loading'),
                laodingTexts = [
                    'The t-shirt gods are spinning yarns for you...',
                    'Pure awesomeness on the way...'
                ];

            let radomKey = random(0,laodingTexts.length - 1),
                randomLoading = laodingTexts[radomKey];

            $.ajax({
                data: form.serializeArray(),
                type: 'post',
                dataType: 'json',
                url: WPURLS.ajaxurl,
                beforeSend: xhr => {
                    loadingWrap.html(`<span>${randomLoading}</span>`);
                    loadingWrap.show();
                    loadMore.hide();
                    // console.log('loading...');
                    form.addClass('loading');
                    $('#mobiSidebar, #filterToggle').removeClass('open');
                    $('body').removeClass('no-overflow');
                },
                success: response => {
                    // console.log(response);

                    // hide the loadmore 
                    if (response.current_page >= response.max) {
                        loadMore.hide();
                    } else {
                        loadMore.fadeIn();
                    }

                    if (response.current_page) {
                        loadMore.find('input[name="current_page"]').val(response.current_page);
                    }

                    // update result counts
                    if (response.found == 1) {
                        result.find('.single').show();
                        result.find('.result, .zero').hide();
                    } else if (!response.found || response.found == 0) {
                        result.find('.zero').show();
                        result.find('.result, .single').hide();
                    } else {
                        let currentVisible = ((response.current_page - 1) * response.ppp) + response.count;
                        result.find('.zero, .single').hide();
                        result.find('.result__total').html(response.found);
                        result.find('.result__current').html(currentVisible);
                        result.find('.result').show();
                    }

                    // collections
                    if (response.collections) {
                        let paramCollections = response.collections.join('&');

                        objectUrl.searchParams.set('collections', encodeURI(paramCollections));
                        window.history.replaceState(null, null, objectUrl);

                        loadMore.find('input[name="collections"]').val(paramCollections);
                    } else {
                        objectUrl.searchParams.delete('collections');
                        window.history.replaceState(null, null, objectUrl);
                        loadMore.find('input[name="collections"]').val('');
                    }

                    // sizes
                    if (response.sizes) {
                        let paramSizes = response.sizes.join('&');

                        objectUrl.searchParams.set('sizes', encodeURI(paramSizes));
                        window.history.replaceState(null, null, objectUrl);
                        loadMore.find('input[name="sizes"]').val(paramSizes);
                    } else {
                        objectUrl.searchParams.delete('sizes');
                        window.history.replaceState(null, null, objectUrl);
                        loadMore.find('input[name="sizes"]').val('');
                    }

                    // colors
                    if (response.colors) {
                        let paramColors = response.colors.join('&');

                        objectUrl.searchParams.set('colors', encodeURI(paramColors));
                        window.history.replaceState(null, null, objectUrl);
                        loadMore.find('input[name="colors"]').val(paramColors);
                    } else {
                        objectUrl.searchParams.delete('colors');
                        window.history.replaceState(null, null, objectUrl);
                        loadMore.find('input[name="colors"]').val('');
                    }

                    // stock
                    if (response.stock) {
                        let paramStock = response.stock.join('&');

                        objectUrl.searchParams.set('stock', encodeURI(paramStock));
                        window.history.replaceState(null, null, objectUrl);
                        loadMore.find('input[name="stock"]').val(paramStock);
                    } else {
                        objectUrl.searchParams.delete('stock');
                        window.history.replaceState(null, null, objectUrl);
                        loadMore.find('input[name="stock"]').val('');
                    }

                    if (response.found > 0) {
                        $('#productGrid').html(response.content);
                        setTimeout(() => {
                            loadingWrap.fadeOut();
                        }, 200);
                    }

                    form.removeClass('loading');
                },
                error: err => {
                    console.log(err);
                }
            });

            return false;
        });
    }

    submitFormWithFilters() {
        let form = $('#shadySidebar'),
            loadMore = $('#loadMoreProducts');

        let urlSearchParams = new URLSearchParams(window.location.search),
            params = Object.fromEntries(urlSearchParams.entries()),
            objectUrl = new URL(window.location.href);

        let collection, size, color = [];

        form.find('input[type=checkbox]').on('change', debounce(e => {
            e.preventDefault();
            form.trigger('submit');
        }, 1000));

        // trigger the filters 
        $(window).one('load', e => {
            // collections
            if (params.collections) {
                params.collections.split('&').forEach(elem => {
                    form.find('input[name="collection[]"]').each((i, item) => {
                        if ($(item).data('value') == elem) {
                            $(item).prop('checked', true);
                        }
                    });
                });
                loadMore.find('input[name="collections"]').val(decodeURI(params.collections));
            }
            // sizes
            if (params.sizes) {
                params.sizes.split('&').forEach(elem => {
                    form.find('input[name="size[]"]').each((i, item) => {
                        if ($(item).data('value') == elem) {
                            $(item).prop('checked', true);
                        }
                    });
                });
                loadMore.find('input[name="sizes"]').val(decodeURI(params.sizes));
            }
            // colors
            if (params.colors) {
                params.colors.split('&').forEach(elem => {
                    form.find('input[name="color[]"]').each((i, item) => {
                        if ($(item).data('value') == elem) {
                            $(item).prop('checked', true);
                        }
                    });
                });
                loadMore.find('input[name="colors"]').val(decodeURI(params.colors));
            }
            // stock
            if (params.stock) {
                params.stock.split('&').forEach(elem => {
                    form.find('input[name="stock[]"]').each((i, item) => {
                        if ($(item).data('value') == elem) {
                            $(item).prop('checked', true);
                        }
                    });
                });
                loadMore.find('input[name="stock"]').val(decodeURI(params.stock));
            }

            // trigger the filter now 
            form.trigger('submit');
        });
    }

    loadMore() {
        let urlSearchParams = new URLSearchParams(window.location.search),
            params = Object.fromEntries(urlSearchParams.entries()),
            objectUrl = new URL(window.location.href);

        let loadmoreForm = $('#loadMoreProducts'),
            filterFrom = $('#shadySidebar'),
            result = $('#resultCount');
        // console.log(params);
        // console.log(params.collections.split('&'));

        if (params.collections) {
            loadmoreForm.find('input[name="collections"]').val(params.collections);
        }
        if (params.sizes) {
            loadmoreForm.find('input[name="sizes"]').val(params.sizes);
        }
        if (params.colors) {
            loadmoreForm.find('input[name="colors"]').val(params.colors);
        }
        if (params.stock) {
            loadmoreForm.find('input[name="stock"]').val(params.stock);
        }

        loadmoreForm.on('submit', e => {
            e.preventDefault();

            // let data = new FormData();
            let data = loadmoreForm.serializeArray();

            // console.log(loadmoreForm.serialize());

            // merge the action and params objs to create the data obj being sent for ajax query
            let dataObj = { ...data, ...params };

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: WPURLS.ajaxurl,
                data: data,
                // processData: false,
                // contentType: false,
                beforeSend: xhr => {
                    // console.log('loading...', data);
                    loadmoreForm.find('button[type="submit"]').addClass('loading');
                    filterFrom.addClass('loading');
                },
                success: response => {
                    // console.log(response);
                    filterFrom.removeClass('loading');

                    // set the page number in the url
                    if (response.current_page) {
                        let pagenum = parseInt(response.current_page);
                        loadmoreForm.find('input[name="current_page"]').val(pagenum);

                        loadmoreForm.find('button[type="submit"]').removeClass('loading');
                        
                        // hide the loadmore 
                        if (response.current_page >= response.max) {
                            loadmoreForm.parents('.load-more-wrap').hide();
                        }
                    }

                    // update result counts
                    if (response.found == 1) {
                        result.find('.single').show();
                        result.find('.result, .zero').hide();
                    } else if (!response.found || response.found == 0) {
                        result.find('.zero').show();
                        result.find('.result, .single').hide();
                    } else {
                        let currentVisible = ((response.current_page - 1) * response.ppp) + response.count;
                        result.find('.zero, .single').hide();
                        result.find('.result__total').html(response.found);
                        result.find('.result__current').html(currentVisible);
                        result.find('.result').show();
                    }

                    if (response.collections) {
                        let paramCollections = response.collections;

                        objectUrl.searchParams.set('collections', encodeURI(paramCollections));
                        window.history.replaceState(null, null, objectUrl);

                        loadmoreForm.find('input[name="collections"]').val(paramCollections);
                    } else {
                        objectUrl.searchParams.delete('collections');
                        window.history.replaceState(null, null, objectUrl);
                        loadmoreForm.find('input[name="collections"]').val('');
                    }

                    // sizes
                    if (response.sizes) {
                        let paramSizes = response.sizes;

                        objectUrl.searchParams.set('sizes', encodeURI(paramSizes));
                        window.history.replaceState(null, null, objectUrl);
                        loadmoreForm.find('input[name="sizes"]').val(paramSizes);
                    } else {
                        objectUrl.searchParams.delete('sizes');
                        window.history.replaceState(null, null, objectUrl);
                        loadmoreForm.find('input[name="sizes"]').val('');
                    }

                    // colors
                    if (response.colors) {
                        let paramColors = response.colors;

                        objectUrl.searchParams.set('colors', encodeURI(paramColors));
                        window.history.replaceState(null, null, objectUrl);
                        loadmoreForm.find('input[name="colors"]').val(paramColors);
                    } else {
                        objectUrl.searchParams.delete('colors');
                        window.history.replaceState(null, null, objectUrl);
                        loadmoreForm.find('input[name="colors"]').val('');
                    }
                    
                    // stock
                    if (response.stock) {
                        let paramStock = response.stock;

                        objectUrl.searchParams.set('stock', encodeURI(paramStock));
                        window.history.replaceState(null, null, objectUrl);
                        loadmoreForm.find('input[name="stock"]').val(paramStock);
                    } else {
                        objectUrl.searchParams.delete('stock');
                        window.history.replaceState(null, null, objectUrl);
                        loadmoreForm.find('input[name="stock"]').val('');
                    }

                    if (response.found > 0) {
                        $('#productGrid').append(response.content);
                    }
                },
                error: err => {
                    console.log(err);
                }
            });

            return false;
        });
    }

    paginationFix() {
        let elem = $('#loadMoreProducts');
        let wayPoint = new Waypoint({
            element: elem[0],
            handler: (direction) => {
                if (this.canBeLoaded === true) {
                    // elem.trigger('click');
                    console.log('sdfghjk');
                    Waypoint.refreshAll();
                }
            },
            offset: 'top-in-view',
        });
    }
}

new ShadyShop();
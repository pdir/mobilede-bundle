/**
 * mobilede for Contao Open Source CMS
 *
 * Copyright (C) 2017 pdir / digital agentur <develop@pdir.de>
 *
 * @package    mobilede
 * @link       https://pdir.de/mobilede
 * @license    pdir license - All-rights-reserved - commercial extension
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

jQuery(document).ready( function ($) {
    var $container = $(".md-ads"),
        $checkboxes = $(".md-filter-attr.checkbox-group input"),
        $selects = $(".md-select"),
        $btnShowFilters = $("#showFilters"),
        updateLocationHash,
        updateFiltersFromObject,
        filters = [];

    // set default filter
    filters['all'] = '*';

    // Create new object for the range filters and set default values
    var rangeFilters = {
        'price': {'min':0, 'max': 100000},
        'power': {'min':0, 'max': 500},
        'mileage': {'min':0, 'max': 1000000}
    };

    var sorting = 'original-order';

    // set Options
    var options = {
        itemSelector: ".item",
        layoutMode: "fitRows", // or masonry
        // use sort functions
        getSortData: {
            price: "[data-price] parseFloat",
            power: "[data-power] parseFloat",
            mileage: "[data-mileage] parseFloat",
            title: function(item) {
                return $(item).find(".title").text();
            },
            number: ".number parseInt",
            category: "[data-category]"
        },
        sortBy: sorting,
        // use filter function
        filter: function() {
            var $this = $(this);
            var price = $this.attr('data-price');
            var isInPriceRange = (rangeFilters['price'].min <= price && rangeFilters['price'].max >= price);

            var power = $this.attr('data-power');
            var isInPowerRange = (rangeFilters['power'].min <= power && rangeFilters['power'].max >= power);

            var mileage = $this.attr('data-mileage');
            var isInMileageRange = (rangeFilters['mileage'].min <= mileage && rangeFilters['mileage'].max >= mileage);

            return $this.is( filters['all'] ) && isInPriceRange && isInPowerRange && isInMileageRange;
        }
    };

    // Initialise Isotope
    $container.isotope(options);

    // show filters
    $btnShowFilters.click(function () {
        $(".md-filters .md-filters-body").toggle();
    });

    // shuffle items
    $("#shuffle").click(function () {
        $container.isotope("shuffle");
    });

    if(mdListShuffle == 1) {
        $("#shuffle").trigger("click");
    }

    //// Event handlers
    $container.on( 'arrangeComplete', function() {
        // if no filtered items display no result message
        if ( !$container.data('isotope').filteredItems.length )
            $('.md-no-result').show();
        else
            $('.md-no-result').hide();
    });

    // Listen to filter update event and update Isotope filters
    $container.on('filter-update', function (event, opts) {

        var checkboxes = [],
            selects = [];

        // Get sorting
        var sorting = $('.md-filters select.sorting').val();
        options.sortBy = sorting ? sorting : 'original-order';

        // Get filters from checkboxes, map input values to an array
        $checkboxes.each( function( i, elem ) {
            // if checkbox, use value if checked
            if ( elem.checked ) {
                checkboxes.push( elem.value );
            }
        });

        filters['checkbox-group'] = checkboxes.length ? checkboxes : '';

        // Get filters from selects, map input values to an array
        $selects.each( function( i, item ) {
            var elem = $(item);

            if(!$(item).hasClass('sorting')) {
                // if checkbox, use value if selected
                if (elem.val() != '*') {
                    selects.push(elem.val());
                }
            }
        });

        filters['select'] = selects.length ? selects.join("") : false;
        filters['select-group'] = selects.length ? selects : '';
        filters['all'] = concatValues(filters);
    });

    // reset filters
    $("#filterReset").on( 'click', function () {
        $(".md-filters input[type=checkbox]").prop("checked", false);
        $(".md-filters option:selected").prop("selected", false);
        var options = $priceSlider.slider( 'option' );
        $priceSlider.slider( 'values', [ options.min, options.max ] );
        options = $powerSlider.slider( 'option' );
        $powerSlider.slider( 'values', [ options.min, options.max ] );
        options = $mileageSlider.slider( 'option' );
        $mileageSlider.slider( 'values', [ options.min, options.max ] );
        $container.isotope({ filter: '*' });
        return false;
    });

    // Initialize checkboxes
    $checkboxes.on( 'change', function( event ) {
        event.preventDefault();
        $container.trigger('filter-update');
        updateLocationHash(filters, options.sortBy);
    });

    // bind filter on select change
    $selects.on( 'change', function( event ) {
        event.preventDefault();
        $container.trigger('filter-update');
        updateLocationHash(filters, options.sortBy);
    });

    // price: get min and max
    var minPrice = parseInt($('.md-ads .item:first-child').data('price'));
    var maxPrice = 0;
    $('.md-ads .item').each( function() {
        var price = parseInt($(this).data('price'));

        if(price < minPrice && price != "") {
            minPrice = price;
        }

        if(price > maxPrice && price != "") {
            maxPrice = price;
        }
    });

    // power: get min and max
    var minPower = parseInt($(".md-ads .item:first-child").data("power"));
    var maxPower = 0;
    $(".md-ads .item").each( function() {
        var power = parseInt($(this).data("power"));

        if(power < minPower && power != "") {
            minPower = power;
        }

        if(power > maxPower && power != "") {
            maxPower = power;
        }
    });

    // mileage: get min and max
    var minMileage = parseInt($(".md-ads .item:first-child").data("mileage"));
    var maxMileage = 0;
    $(".md-ads .item").each( function() {
        var mileage = parseInt($(this).data("mileage"));

        if(mileage < minMileage && mileage != "") {
            minMileage = mileage;
        }

        if(mileage > maxMileage && mileage != "") {
            maxMileage = mileage;
        }
    });

    // Initialize Slider
    var $priceSlider = $('#priceSlider').slider({
        tooltip_split: true,
        min: minPrice ? minPrice : rangeFilters['price'],
        max: maxPrice ? maxPrice : rangeFilters['price'],
        range: true,
        values: [
            minPrice ? minPrice : rangeFilters['price'],
            maxPrice ? maxPrice : rangeFilters['price']
        ]
    });

    var $powerSlider = $('#powerSlider').slider({
        tooltip_split: true,
        min: minPower ? minPower : rangeFilters['power'],
        max: maxPower ? maxPower : rangeFilters['power'],
        range: true,
        values: [
            minPower ? minPower : rangeFilters['power'],
            maxPower ? maxPower : rangeFilters['power']
        ]
    });

    var $mileageSlider = $('#mileageSlider').slider({
        tooltip_split: true,
        min: minMileage ? minMileage : rangeFilters['mileage'],
        max: maxMileage ? maxMileage : rangeFilters['mileage'],
        range: true,
        values: [
            minMileage ? minMileage : rangeFilters['mileage'],
            maxMileage ? maxMileage : rangeFilters['mileage']
        ]
    });

    var minPriceString = minPrice.toLocaleString('de-DE', { style: 'currency', currency: 'EUR' });
    var maxPriceString = maxPrice.toLocaleString('de-DE', { style: 'currency', currency: 'EUR' });
    var minPowerString = minPower.toLocaleString('de-DE', { style: 'decimal' }) + "KW";
    var maxPowerString = maxPower.toLocaleString('de-DE', { style: 'decimal' }) + "KW";
    var minMileageString = minMileage.toLocaleString('de-DE', { style: 'decimal' }) + "km";
    var maxMileageString = maxMileage.toLocaleString('de-DE', { style: 'decimal' }) + "km";
    $("#priceSlider .ui-slider-handle:nth-of-type(1)").attr('data-price-min',minPriceString);
    $("#priceSlider .ui-slider-handle:nth-of-type(2)").attr('data-price-max',maxPriceString);
    $("#powerSlider .ui-slider-handle:nth-of-type(1)").attr('data-power-min',minPowerString);
    $("#powerSlider .ui-slider-handle:nth-of-type(2)").attr('data-power-max',maxPowerString);
    $("#mileageSlider .ui-slider-handle:nth-of-type(1)").attr('data-mileage-min',minMileageString);
    $("#mileageSlider .ui-slider-handle:nth-of-type(2)").attr('data-mileage-max',maxMileageString);

    function updateRangeSlider(slider, slideEvt, ui) {
        var sldmin = +ui.values[0],
            sldmax = +ui.values[1],
            // Find which filter group this slider is in (in this case it will be either height or weight)
            // This can be changed by modifying the data-filter-group="age" attribute on the slider HTML
            filterGroup = slider.attr('data-filter-group');

        // Update filter label with new range selection

        var id = slider.attr("id");

        if(id == "priceSlider") {
            var sldminString = sldmin.toLocaleString('de-DE', { style: 'currency', currency: 'EUR' });
            var sldmaxString = sldmax.toLocaleString('de-DE', { style: 'currency', currency: 'EUR' });
            $(".ui-slider-handle:nth-of-type(1)").attr('data-price-min',sldminString);
            $(".ui-slider-handle:nth-of-type(2)").attr('data-price-max',sldmaxString);
        }
        if(id == "powerSlider") {
            var sldminString = sldmin.toLocaleString('de-DE', { style: 'decimal' }) + "KW";
            var sldmaxString = sldmax.toLocaleString('de-DE', { style: 'decimal' }) + "KW";
            $(".ui-slider-handle:nth-of-type(1)").attr('data-power-min',sldminString);
            $(".ui-slider-handle:nth-of-type(2)").attr('data-power-max',sldmaxString);
        }
        if(id == "mileageSlider") {
            var sldminString = sldmin.toLocaleString('de-DE', { style: 'decimal' }) + "km";
            var sldmaxString = sldmax.toLocaleString('de-DE', { style: 'decimal' }) + "km";
            $(".ui-slider-handle:nth-of-type(1)").attr('data-mileage-min',sldminString);
            $(".ui-slider-handle:nth-of-type(2)").attr('data-mileage-max',sldmaxString);
        }

        // Set min and max values for current selection to current selection
        // If no values are found set min to 0 and max to 100000
        // Store min/max values in rangeFilters array in the relevant filter group
        // E.g. rangeFilters['height'].min and rangeFilters['height'].max
        rangeFilters[filterGroup] = {
            min: sldmin || min,
            max: sldmax || max
        };
        // Trigger isotope again to refresh layout
        $container.isotope(options);
    }

    // Trigger Isotope Filter when slider drag has stopped
    $priceSlider.on('slide', function(slideEvt, ui){
        var $this =$(this);
        updateRangeSlider($this, slideEvt, ui);
    });
    $powerSlider.on('slide', function(slideEvt, ui){
        var $this =$(this);
        updateRangeSlider($this, slideEvt, ui);
    });
    $mileageSlider.on('slide', function(slideEvt, ui){
        var $this =$(this);
        updateRangeSlider($this, slideEvt, ui);
    });
    //// Helper functions
    // Update the page history state
    updateLocationHash = function (filters, sorting) {

        var hash = '';

        // filter
        if(filters['all'] !== '*')
            hash = 'filter=' + encodeURIComponent( filters['all'] );

        if(filters['all'] !== '*' && sorting !== 'original-order')
            hash += '&';

        // sorting
        if(sorting !== 'original-order')
            hash += 'sort=' + encodeURIComponent( sorting );

        location.hash = hash;

        console.log('filter now');
        console.log(options);
        $container.isotope(options);
    };

    getHashFilter = function() {
        // get filter=filterName
        var matches = location.hash.match( /filter=([^&]+)/i );
        var hashFilter = matches && matches[1];
        return hashFilter && decodeURIComponent( hashFilter );
    };

    getHashSorting = function() {
        // get filter=filterName
        var matches = location.hash.match( /sort=([^&]+)/i );
        var hashSorting = matches && matches[1];
        return hashSorting && decodeURIComponent( hashSorting );
    };

    // Update filters from current url
    updateFiltersFromHash = function () {

        console.log('updateFiltersFromHash');

        var hashFilter = getHashFilter();
        var sortFilter = getHashSorting();

        if ( !hashFilter && !sortFilter) {
            return;
        }

        if(hashFilter !== null)
        {
            var filterArr = hashFilter.split('.');

            // unset all selects
            $('.md-select').val('*');

            // set filters from hash
            $.each(filterArr, function (key, val) {
                if(val) {
                    console.log(key);
                    console.log(val);
                    console.log('.md-select option[value=".' + val + '"]');
                    $('.md-select option[value=".' + val + '"]').parent().val('.'+val);
                    $('.md-filter-attr :checkbox[value=".' + val + '"]').prop('checked','true');
                }
            });
        }

        // set sorting from hash
        $('.md-select.sorting').val(sortFilter);

        $container.trigger('filter-update');

        $container.isotope(options);
    };

    // Flatten object by concatting values
    concatValues = function( obj ) {
        var arr = [];
        // console.log(obj);
        if(typeof obj['checkbox-group'] !== 'undefined' && obj['checkbox-group'] !== '') {
            for (var prop in obj['checkbox-group']) {
                if(obj['select'])
                    arr.push(obj['checkbox-group'][prop] + obj['select']);
                else
                    arr.push(obj['checkbox-group'][prop]);
            }
            return arr.join(",");
        }

        console.log(obj['select'].length);
        console.log(!obj['select']);
        if(!obj['select'] || 0 === obj['select'].length)
        {
            console.log('select is empty');
            return '*';
        }


        return obj['select'];
    };

    $(window).on( 'hashchange', updateFiltersFromHash );
});
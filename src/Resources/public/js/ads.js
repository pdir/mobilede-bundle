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
        $btnShowFilters = $("#showFilters");


    // Create object to store filter for each group
    var buttonFilters = {};
    var buttonFilter = '*';

    // Create new object for the range filters and set default values
    var rangeFilters = {
        'price': {'min':0, 'max': 100000}
    };

    // set Options
    var options = {
        itemSelector: ".item",
        layoutMode: "fitRows", // or masonry
        // use sort functions
        getSortData: {
            price: ".price parseFloat",
            title: function(item) {
                return $(item).find(".title a").text();
            },
            number: ".number parseInt",
            category: "[data-category]"
        },
        // use filter function
        filter: function() {

            var $this = $(this);
            var price = $this.attr('data-price');
            var isInPriceRange = (rangeFilters['price'].min <= price && rangeFilters['price'].max >= price);

            return $this.is( buttonFilter ) && isInPriceRange;
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

    // reset filters
    $("#filterReset").click(function () {
        $(".md-filters input[type=checkbox]").prop("checked", false);
        $(".md-filters option:selected").prop("selected", false);
        var options = $priceSlider.slider( 'option' );
        $priceSlider.slider( 'values', [ options.min, options.max ] );
        $container.isotope({ filter: '*' });
        return false;
    });

    // Initialize checkboxes
    $checkboxes.change( function() {
        var $this = $(this);

        // map input values to an array
        var inclusives = [];
        // inclusive filters from checkboxes
        $checkboxes.each( function( i, elem ) {
            // if checkbox, use value if checked
            if ( elem.checked ) {
                inclusives.push( elem.value );
            }
        });

        buttonFilters[ 'checkbox-group' ] = $this.attr('data-filter');

        // combine inclusive filters
        buttonFilter = inclusives.length ? inclusives.join(", ") : "*";

        $container.isotope();
    });

    // bind filter on select change
    $(".md-select").on( "change", function() {
        var $this = $(this);
        // get filter value from option value
        buttonFilters[ 'select-group' ] = $this.val();

        var inclusives = [];
        // inclusive filters from checkboxes
        $(".md-select").each( function( i, elem ) {
            // if checkbox, use value if selected
            if ( elem.selected ) {
                inclusives.push( elem.value );
            }
        });
        buttonFilter = inclusives.length ? inclusives.join(", ") : "*";

        $container.isotope();
    });

    // get min and max price
    var min = parseInt($(".md-ads .item:first-child").data("price"));
    var max = 0;
    $(".md-ads .item").each( function() {
        var price = parseInt($(this).data("price"));

        if(price < min && price != "") {
            min = price;
        }

        if(price > max && price != "") {
            max = price;
        }
    });


    // Initialize Slider
    var $priceSlider = $('#priceSlider').slider({
        tooltip_split: true,
        min: min,
        max: max,
        range: true,
        value: [min, max]
    });

    var minString = min.toLocaleString('de-DE', { style: 'currency', currency: 'EUR' });
    var maxString = max.toLocaleString('de-DE', { style: 'currency', currency: 'EUR' });
    $(".range-slider .min").text(minString);
    $(".range-slider .max").text(maxString);
    $(".ui-slider-handle:nth-of-type(1)").attr('data-min',minString);
    $(".ui-slider-handle:nth-of-type(2)").attr('data-max',maxString);

    var $priceSliderTooltip = $('#priceSlider .tooltip .tooltip-inner');

    var _changeTooltipFormat = function(){
        $priceSliderTooltip.text($priceSliderTooltip.text()+'€');
    };

    //change tooltip format on initial load
    _changeTooltipFormat();

    function updateRangeSlider(slider, slideEvt, ui) {
        var sldmin = +ui.values[0],
            sldmax = +ui.values[1],
            // Find which filter group this slider is in (in this case it will be either height or weight)
            // This can be changed by modifying the data-filter-group="age" attribute on the slider HTML
            filterGroup = slider.attr('data-filter-group');

        // Update filter label with new range selection

        var sldminString = sldmin.toLocaleString('de-DE', { style: 'currency', currency: 'EUR' });
        var sldmaxString = sldmax.toLocaleString('de-DE', { style: 'currency', currency: 'EUR' });
        $(".ui-slider-handle:nth-of-type(1)").attr('data-min',sldminString);
        $(".ui-slider-handle:nth-of-type(2)").attr('data-max',sldmaxString);

        // Set min and max values for current selection to current selection
        // If no values are found set min to 0 and max to 100000
        // Store min/max values in rangeFilters array in the relevant filter group
        // E.g. rangeFilters['height'].min and rangeFilters['height'].max
        rangeFilters[filterGroup] = {
            min: sldmin || min,
            max: sldmax || max
        };
        // Trigger isotope again to refresh layout
        $container.isotope();

        _changeTooltipFormat();
    }

    // Trigger Isotope Filter when slider drag has stopped
    $priceSlider.on('slide', function(slideEvt, ui){
        var $this =$(this);
        updateRangeSlider($this, slideEvt, ui);
    });
});

// Flatten object by concatting values
function concatValues( obj ) {
    var value = '';
    for ( var prop in obj ) {
        value += obj[ prop ];
    }
    return value;
}
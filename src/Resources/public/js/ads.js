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

jQuery(function ($) {
    var $container = $(".md-ads"),
        $checkboxes = $(".md-filter-attr.checkbox-group input");

    var options = {
        itemSelector: ".item",
        layoutMode: "fitRows",
        getSortData: {
            price: ".price parseFloat",
            title: function(item) {
                return $(item).find(".title a").text();
            },
            number: ".number parseInt",
            category: "[data-category]"
        }
    };

    if (typeof mdListShuffle != "undefined")
        options.sortBy = "random";

    $container.isotope(options);

	$checkboxes.change( function() {
		// map input values to an array
		var inclusives = [];
		// inclusive filters from checkboxes
		$checkboxes.each( function( i, elem ) {
			// if checkbox, use value if checked
			if ( elem.checked ) {
				inclusives.push( elem.value );
			}
		});

		// combine inclusive filters
		var filterValue = inclusives.length ? inclusives.join(", ") : "*";
		$container.isotope({ filter: filterValue });
	});

    $("#shuffle").click(function () {
        $container.isotope("shuffle");
    });

	$("#filterReset").click(function () {
		$(".md-filters input[type=checkbox]").prop("checked", false);
		$(".md-filters option:selected").prop("selected", false);
		$container.isotope( {filter: "*", sortBy: "original-order"} );
		return false;
	});

	$("#showFilters").click(function () {
		$(".md-filters .md-filters-body").toggle();
	});

    // bind sort button click
	/*
    $(".md-filter-sort select").on("click", "button", function () {
    	console.log( $(this).attr("data-filter") );
		console.log( $(".md-filter-sort select option:selected").val() );
		console.log( $(".md-filter-sort select option:selected").attr("data-filter") );
        var sortByValue = $(".md-filter-sort select option:selected").attr("data-filter");
        $container.isotope({sortBy: sortByValue});
    });*/

    // change is-checked class on buttons
    $(".button-group").each(function (i, buttonGroup) {
        var $buttonGroup = $(buttonGroup);
        $buttonGroup.on("click", "button", function () {
            $buttonGroup.find(".is-checked").removeClass("is-checked");
            $(this).addClass("is-checked");
        });
    });

    // filter functions
    var filterFns = {
        // show if number is greater than 50
        numberGreaterThan50: function() {
            var number = $(this).find(".number").text();
            return parseInt( number, 10 ) > 50;
        },
        // show if name ends with -ium
        ium: function() {
            var name = $(this).find(".name").text();
            return name.match( /ium$/ );
        },
        priceSlider: function() {
            console.log("test");
            var min = ui.values[0];
            var max = ui.values[1];
            // get number
            var numberString = $(this).find('.price span').text();
            // get only the number and remove all after the number
            numberString = numberString.substr(0,numberString.indexOf("EUR"));
            var number = numberString.replace(",","");
            // filtering
            return parseInt( number, 10 ) > min && parseInt( number, 10 ) < max;
        }
    };

    // bind filter on select change
    $(".md-select").on( "change", function() {
        // get filter value from option value
        var filterValue = this.value;
        // use filterFn if matches value
        filterValue = filterFns[ filterValue ] || filterValue;
        console.log(filterValue);
		var options = {filter: filterValue};
		// sortierung
		if( $(this).children("option:selected").attr("data-filter-type") == "sort" ) {
			options = {sortBy: filterValue};
		}
        $container.isotope( options );
    });

    // Range Slider
    $(".md-ads .price span").each( function() {
        var price = $(this).text();
        price = price.substr(0,price.indexOf("EUR"));
        price = price.replace(",","");
        console.log(price);
    });

    $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 50000,
        values: [ 0, 50000 ],
        slide: function( event, ui ) {
            $( "#amount" ).val(ui.values[0] + " € - " + ui.values[1] + " €" );
            var min = ui.values[0];
            var max = ui.values[1];

            $(".md-select").trigger("change");
        }
    });
    $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
    " € - " + $( "#slider-range" ).slider( "values", 1 ) + " €" );


});
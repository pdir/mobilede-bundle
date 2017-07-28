
var apiUrl = 'https://pdir.de/api/mobilede/';

window.addEvent('domready', function() {

	// dev log
    var devlogUrl = 'https://pdir.de/share/mobilede-devlog.xml';
    var devlog = $('mobileDeDevLog');

    if(devlog) {
        var req = new Request.HTML({
            method: 'get',
            url: devlogUrl,
            onSuccess: function(tree, elements, html) {
                var temp = new Element('div').set('html', html);

                temp.getElements('item').each(function(el) {
                    var d = new Date(el.getElements('pubdate')[0].innerText);
                    var curr_date = ((d.getDate()<10)? "0"+d.getDate(): d.getDate());
                    var curr_month = ((d.getMonth()<10)? "0"+(d.getMonth()+1): (d.getMonth()+1));
                    var curr_year = d.getFullYear();
                    var itemHTML = '<span>'+curr_date + "." + curr_month + "." + curr_year+'</span>';
                    itemHTML += '<span>'+el.getElements('title')[0].innerText+'</span>';
                    itemHTML += '<a href="'+el.getElements('guid')[0].innerText+'" target="_blank"> [ lesen ] </a>';
                    itemHTML += '<div>'+el.getElements('description')[0].innerText.replace(']]>', '')+'</div>';

                    var newItem = new Element('div').addClass('item').set('html', itemHTML);
                    devlog.adopt(newItem);
                });
            }
        }).send();
    }

});

function getApiStatus() {

	jQuery.ajax({
		type: 'GET',
		contentType: 'application/json',
		url: apiUrl,
		success: function(data, textStatus, jqXHR){
			console.log('Api status ok');
		},
		error: function(jqXHR, textStatus, errorThrown){
			jQuery("#spushApiStatus").addClass("red");
			console.log('status error: ' + textStatus);

		}
	});
}
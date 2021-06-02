
window.addEvent("domready", function() {
    var pdirVehicleInfo = document.getElementById('pdirVehicleInfo');

    if(pdirVehicleInfo) {
        // move vehicle info to bottom
        var fragment = document.createDocumentFragment();
        fragment.appendChild(document.getElementById('pdirVehicleInfo'));
        var cont = document.getElementById('tl_listing') !== null ? document.getElementById('tl_listing') : document.getElementsByClassName('tl_empty')[0];

        if (typeof cont !== 'null') {
            cont.appendChild(fragment);
        }
    }

});

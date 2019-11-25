
var map;
function getLatLngFromString(ll) {
    var latlng = ll.replace(/[()]/g,'');
    var latlngb = latlng.split(',')
    return new google.maps.LatLng(parseFloat(latlngb[0]), parseFloat(latlngb[1])); 
}

//Codigo para evitar que el api de Google Maps cargue la fuente roboto por segunda vez
//----------------------------------------------------------------//
var head = document.getElementsByTagName('head')[0];
var insertBefore = head.insertBefore;

head.insertBefore = function (newElement, referenceElement) {

    if (newElement.href && newElement.href.indexOf('https://fonts.googleapis.com/css?family=Roboto') === 0) {

        //console.info('Prevented Roboto from loading!');
        return;
    }

    insertBefore.call(head, newElement, referenceElement);
};
//----------------------------------------------------------------//

function initialize() {
  var latlng = new google.maps.LatLng(40.4163128,-3.7020142);
  var mapOptions = {
    zoom: 8,
    center: latlng
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  if($("input[name=ubicacionLatLong]").attr("value").length > 0){
    latLng = getLatLngFromString($("[name=ubicacionLatLong]").attr("value"));
    map.setCenter(latLng);
    map.setZoom(14);
    marker = new google.maps.Marker({
      position: latLng,
      map: map
    });
  }
}

$(document).ready(initialize);

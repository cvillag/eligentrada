
var geocoder;
var map;
var marker;

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
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(40.4163128,-3.7020142);
  var mapOptions = {
    zoom: 4,
    center: latlng
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  if($("[name=ubicacionLatLong]").attr("value").length > 0){
    latLng = getLatLngFromString($("[name=ubicacionLatLong]").attr("value"));
    map.setCenter(latLng);
    map.setZoom(14);
    marker = new google.maps.Marker({
      position: latLng,
      map: map
    });
  }

  google.maps.event.addListener(map, 'click', function(e) {
    if(marker == undefined){
      marker = new google.maps.Marker({
        position: e.latLng,
        map: map
      });
    } else {
      marker.setPosition(e.latLng);
    }
    $("[name=ubicacionLatLong]").attr("value", e.latLng);
    geocoder.geocode({'latLng':e.latLng},function(data,status){
      if(status == google.maps.GeocoderStatus.OK){
        $("#address").val(data[1].formatted_address); //this is the full address
      }
    });
  });
}

function codeAddress() {
  var address = $("#address").val();
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      map.setZoom(16);
      if(marker == undefined) {
        marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
        });
        $("[name=ubicacionLatLong]").attr("value", results[0].geometry.location);
      }
    } else {
      console.log('Geocode was not successful for the following reason: ' + status);
    }
  });
}

$(document).ready(initialize);
$("#address").change(codeAddress);
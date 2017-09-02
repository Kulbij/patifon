
var directionDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function map_initialize() {
 directionsDisplay = new google.maps.DirectionsRenderer();
 var destination = new google.maps.LatLng(50.4403111,30.4831866);
 
 var styleArray = [
  {
    featureType: "poi.business",
    elementType: "labels",
    stylers: [
      { visibility: "off" }
    ]
  }
 ];
 
 var myOptions = {
   zoom: 9,
   mapTypeId: google.maps.MapTypeId.ROADMAP,
   center: destination/*,
   styles: styleArray*/
 }
 
 if (document.getElementById('map_canvas')) {
  map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
  
  directionsDisplay.setMap(map);
  directionsDisplay.setOptions( { suppressMarkers: true } );

  //directionsDisplay.setPanel(document.getElementById('directionsPanel'));
  var marker = new google.maps.Marker({
    position: destination,
    map: map,
    title: ""/*,
    icon: CI_ROOT + 'public/images/map-point.png'*/
  });
  
  var infoWindow = new google.maps.InfoWindow();
  var html = '<div style="width: 300px; height: 50px;">' + $('#map_address').html() + '</div>';
  google.maps.event.addListener(marker, 'click', function() {
   infoWindow.setContent(html);
   infoWindow.open(map, marker);
  });
  
  map.setZoom(17);
 }
 
 if (document.getElementById('map_footer_canvas')) {
  map2 = new google.maps.Map(document.getElementById('map_footer_canvas'), myOptions);
  
  directionsDisplay.setMap(map2);
  directionsDisplay.setOptions( { suppressMarkers: true } );

  //directionsDisplay.setPanel(document.getElementById('directionsPanel'));
  var marker = new google.maps.Marker({
    position: destination,
    map: map2,
    title: ""/*,
    icon: CI_ROOT + 'public/images/map-point.png'*/
  });
  
  map2.setZoom(17);
 }
 
}
  
function calcRoute() {
 var start = document.getElementById('address').value;
 var end = new google.maps.LatLng(50.4403111,30.4831866);
 var request = {
     origin:start, 
     destination: end,
     travelMode: google.maps.DirectionsTravelMode.DRIVING
 };
 directionsService.route(request, function(response, status) {
   if (status == google.maps.DirectionsStatus.OK) {
     directionsDisplay.setDirections(response);
   }
 });
}
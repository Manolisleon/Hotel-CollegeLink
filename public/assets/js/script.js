// Initialize and add the map
function initMap() {
  const $lat = document.querySelector('lat');
  const $lng = document.querySelector('lng');
  // The location of Uluru
  const uluru = { lat: $lat, lng: $lng };
  // The map, centered at Uluru
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 12,
    center: uluru,
  });
  // The marker, positioned at Uluru
  const marker = new google.maps.Marker({
    position: uluru,
    map: map,
  });
}

window.initMap = initMap;


document.addEventListener('DOMContentLoaded', function () {
    let defaultLat = -14.2350;
    let defaultLng = -51.9253;
    let zoomLevel = 4;

    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    if (!latInput || !lngInput) return;

    if (latInput.value && lngInput.value) {
        defaultLat = parseFloat(latInput.value);
        defaultLng = parseFloat(lngInput.value);
        zoomLevel = 14;
    }

    const map = L.map('map').setView([defaultLat, defaultLng], zoomLevel);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker;

    if (latInput.value && lngInput.value) {
        marker = L.marker([defaultLat, defaultLng]).addTo(map);
    }

    if (!latInput.value && navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            map.setView([
                position.coords.latitude,
                position.coords.longitude
            ], 14);
        });
    }

    map.on('click', function(e) {
        const { lat, lng } = e.latlng;

        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([lat, lng]).addTo(map);

        latInput.value = lat;
        lngInput.value = lng;
    });

    document.getElementById('map')
        ?.addEventListener('mousedown', e => e.preventDefault());
});
<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <!-- Leaflet's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Localização Atual</h4>
            <a href="index.php" class="btn btn-primary float-end">Voltar</a>
        </div>
        <div id="map" style="height: 300px;"></div> 
    </div>
</div>

<!-- Leaflet's JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="">
</script>

<script>
var map = L.map('map').setView([-20.524, -47.424], 13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var marker = L.marker([-20.524, -47.424]).addTo(map)
    .bindPopup("Sua localização: Franca-SP").openPopup();
</script>

<?php include('includes/footer.php'); ?>
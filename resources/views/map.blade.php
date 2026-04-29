@extends('layouts.template')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

<style>
    #map {
        height: calc(100vh - 56px);
    }
</style>
@endsection

@section('content')
<div id="map"></div>

{{-- ================= POINT MODAL ================= --}}
<div class="modal fade" id="modalInputPoint">
  <div class="modal-dialog">
    <form action="{{ route('points.store') }}" method="POST" enctype="multipart/form-data" class="modal-content shadow">
      @csrf

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">📍 Input Data Point</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Lokasi</label>
          <input type="text" name="name" class="form-control" placeholder="Contoh: Kampus UGM">
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" class="form-control" rows="2" placeholder="Masukkan deskripsi singkat lokasi"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Geometry (Otomatis dari peta)</label>
          <textarea id="geometry_point" name="geometry_point" class="form-control" rows="2" readonly></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Upload Gambar</label>
          <input type="file" name="image" class="form-control" onchange="previewImage(event,'preview_point')">
          <small class="text-muted">Format: JPG/PNG, maksimal 2MB</small>
          <img id="preview_point" class="img-thumbnail mt-2" width="200" style="display:none;">
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">💾 Simpan</button>
      </div>

    </form>
  </div>
</div>

{{-- ================= POLYLINE MODAL ================= --}}
<div class="modal fade" id="modalInputPolyline">
  <div class="modal-dialog">
    <form action="{{ route('polylines.store') }}" method="POST" enctype="multipart/form-data" class="modal-content shadow">
      @csrf

      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">📏 Input Data Polyline</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Jalur</label>
          <input type="text" name="name" class="form-control" placeholder="Contoh: Jalan Malioboro">
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" class="form-control" rows="2" placeholder="Deskripsi jalur"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Geometry (Otomatis)</label>
          <textarea id="geometry_polyline" name="geometry_polyline" class="form-control" rows="2" readonly></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Upload Gambar</label>
          <input type="file" name="image" class="form-control" onchange="previewImage(event,'preview_polyline')">
          <img id="preview_polyline" class="img-thumbnail mt-2" width="200" style="display:none;">
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">💾 Simpan</button>
      </div>

    </form>
  </div>
</div>

{{-- ================= POLYGON MODAL ================= --}}
<div class="modal fade" id="modalInputPolygon">
  <div class="modal-dialog">
    <form action="{{ route('polygons.store') }}" method="POST" enctype="multipart/form-data" class="modal-content shadow">
      @csrf

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">🗺️ Input Data Polygon</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Area</label>
          <input type="text" name="name" class="form-control" placeholder="Contoh: Area Kampus">
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" class="form-control" rows="2" placeholder="Deskripsi area"></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Geometry (Otomatis)</label>
          <textarea id="geometry_polygon" name="geometry_polygon" class="form-control" rows="2" readonly></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Upload Gambar</label>
          <input type="file" name="image" class="form-control" onchange="previewImage(event,'preview_polygon')">
          <img id="preview_polygon" class="img-thumbnail mt-2" width="200" style="display:none;">
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">💾 Simpan</button>
      </div>

    </form>
  </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://unpkg.com/@terraformer/wkt"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// ================= PREVIEW IMAGE =================
function previewImage(event, targetId){
    const img = document.getElementById(targetId);
    img.src = URL.createObjectURL(event.target.files[0]);
    img.style.display = 'block';
}

// ================= MAP INIT =================
const map = L.map('map').setView([-7.7956,110.3695],13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

// ================= DRAW =================
const drawnItems = new L.FeatureGroup();
map.addLayer(drawnItems);

map.addControl(new L.Control.Draw({
    draw:{
        polyline:true,
        polygon:true,
        rectangle:true,
        marker:true,
        circle:false,
        circlemarker:false
    }
}));

map.on('draw:created', function(e){
    const type = e.layerType.toLowerCase();
    const layer = e.layer;

    const geojson = layer.toGeoJSON();
    const wkt = Terraformer.geojsonToWKT(geojson.geometry);

    if(type === 'polyline'){
        document.getElementById('geometry_polyline').value = wkt;
        new bootstrap.Modal(document.getElementById('modalInputPolyline')).show();
    }
    else if(type === 'polygon' || type === 'rectangle'){
        document.getElementById('geometry_polygon').value = wkt;
        new bootstrap.Modal(document.getElementById('modalInputPolygon')).show();
    }
    else if(type === 'marker'){
        document.getElementById('geometry_point').value = wkt;
        new bootstrap.Modal(document.getElementById('modalInputPoint')).show();
    }

    drawnItems.addLayer(layer);
});

// ================= GEOJSON =================
function popupContent(feature){
    return `
        Nama: ${feature.properties.name}<br>
        Deskripsi: ${feature.properties.description}<br>
        ${feature.properties.image
            ? `<img src="/storage/images/${feature.properties.image}" width="200">`
            : 'Tidak ada gambar'}
    `;
}

const points = L.geoJSON(null,{
    onEachFeature:(f,l)=>l.bindPopup(popupContent(f))
});

const polylines = L.geoJSON(null,{
    style:{color:'blue'},
    onEachFeature:(f,l)=>l.bindPopup(popupContent(f))
});

const polygons = L.geoJSON(null,{
    style:{color:'green'},
    onEachFeature:(f,l)=>l.bindPopup(popupContent(f))
});

// ================= LOAD DATA =================
$.getJSON("{{ route('api.geojson_points') }}", data => points.addData(data));
$.getJSON("{{ route('api.geojson_polylines') }}", data => polylines.addData(data));
$.getJSON("{{ route('api.geojson_polygons') }}", data => polygons.addData(data));

points.addTo(map);
polylines.addTo(map);
polygons.addTo(map);

L.control.layers(null,{
    Points:points,
    Polylines:polylines,
    Polygons:polygons
}).addTo(map);

</script>
@endsection

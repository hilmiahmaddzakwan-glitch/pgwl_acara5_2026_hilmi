@extends('layouts.template')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    #map {
        height: calc(100vh - 56px);
    }

    .delete-btn {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        margin-top: 10px;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
    }

    .delete-btn:hover {
        background-color: #c82333;
    }

    .edit-btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 5px 10px;
        margin-top: 5px;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
    }

    .edit-btn:hover {
        background-color: #0056b3;
    }

    .popup-geometry {
        background-color: #f8f9fa;
        padding: 8px;
        margin-top: 8px;
        border-radius: 4px;
        font-size: 11px;
        font-family: monospace;
        word-break: break-all;
        max-height: 100px;
        overflow-y: auto;
        border: 1px solid #dee2e6;
    }

    .popup-geometry-label {
        font-weight: bold;
        color: #495057;
        margin-bottom: 5px;
        font-size: 12px;
    }
</style>
@endsection

@section('content')
<div id="map"></div>

{{-- ================= POINT MODAL ================= --}}
<div class="modal fade" id="modalInputPoint">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('points.store') }}" method="POST" enctype="multipart/form-data" class="modal-content shadow">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">
            <i class="fas fa-map-marker-alt"></i> Input Data Point
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Lokasi</label>
          <input type="text" name="name" class="form-control" placeholder="Contoh: Kampus UGM" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" class="form-control" rows="2" placeholder="Masukkan deskripsi singkat lokasi" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Geometry (WKT Format)</label>
          <textarea id="geometry_point" name="geometry" class="form-control" rows="2" readonly required></textarea>
          <small class="text-muted">Geometry akan otomatis terisi dari gambar yang Anda buat di peta</small>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Upload Gambar</label>
          <input type="file" name="image" id="image_point" class="form-control" accept="image/*" onchange="previewImage(event, 'preview_point')">
          <small class="text-muted">Format: JPG/PNG, maksimal 2MB</small>
          <img id="preview_point" class="img-thumbnail mt-2" width="200" style="display:none;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">💾 Simpan Point</button>
      </div>
    </form>
  </div>
</div>

{{-- ================= POLYLINE MODAL ================= --}}
<div class="modal fade" id="modalInputPolyline">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('polylines.store') }}" method="POST" enctype="multipart/form-data" class="modal-content shadow">
      @csrf
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">
            <i class="fas fa-chart-line"></i> Input Data Polyline
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Jalur</label>
          <input type="text" name="name" class="form-control" placeholder="Contoh: Jalan Malioboro" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" class="form-control" rows="2" placeholder="Deskripsi jalur" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Geometry (WKT Format)</label>
          <textarea id="geometry_polyline" name="geometry" class="form-control" rows="2" readonly required></textarea>
          <small class="text-muted">Geometry akan otomatis terisi dari gambar yang Anda buat di peta</small>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Upload Gambar</label>
          <input type="file" name="image" id="image_polyline" class="form-control" accept="image/*" onchange="previewImage(event, 'preview_polyline')">
          <small class="text-muted">Format: JPG/PNG, maksimal 2MB</small>
          <img id="preview_polyline" class="img-thumbnail mt-2" width="200" style="display:none;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-info text-white">💾 Simpan Polyline</button>
      </div>
    </form>
  </div>
</div>

{{-- ================= POLYGON MODAL ================= --}}
<div class="modal fade" id="modalInputPolygon">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('polygons.store') }}" method="POST" enctype="multipart/form-data" class="modal-content shadow">
      @csrf
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">
            <i class="fas fa-draw-polygon"></i> Input Data Polygon
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Area</label>
          <input type="text" name="name" class="form-control" placeholder="Contoh: Area Kampus" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" class="form-control" rows="2" placeholder="Deskripsi area" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Geometry (WKT Format)</label>
          <textarea id="geometry_polygon" name="geometry" class="form-control" rows="2" readonly required></textarea>
          <small class="text-muted">Geometry akan otomatis terisi dari gambar yang Anda buat di peta</small>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Upload Gambar</label>
          <input type="file" name="image" id="image_polygon" class="form-control" accept="image/*" onchange="previewImage(event, 'preview_polygon')">
          <small class="text-muted">Format: JPG/PNG, maksimal 2MB</small>
          <img id="preview_polygon" class="img-thumbnail mt-2" width="200" style="display:none;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">💾 Simpan Polygon</button>
      </div>
    </form>
  </div>
</div>

{{-- ================= EDIT MODALS ================= --}}
<!-- Edit Point Modal -->
<div class="modal fade" id="modalEditPoint">
  <div class="modal-dialog modal-lg">
    <form id="formEditPoint" method="POST" enctype="multipart/form-data" class="modal-content shadow">
      @csrf
      @method('PUT')
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">
            <i class="fas fa-edit"></i> Edit Data Point
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit_point_id">

        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Lokasi</label>
          <input type="text" name="name" id="edit_point_name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" id="edit_point_description" class="form-control" rows="2" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Upload Gambar Baru</label>
          <input type="file" name="image" class="form-control" accept="image/*" onchange="previewEditImage(event, 'edit_preview_point')">
          <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
          <img id="edit_preview_point" class="img-thumbnail mt-2" width="200" style="display:none;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">✏️ Update Point</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Polyline Modal -->
<div class="modal fade" id="modalEditPolyline">
  <div class="modal-dialog modal-lg">
    <form id="formEditPolyline" method="POST" enctype="multipart/form-data" class="modal-content shadow">
      @csrf
      @method('PUT')
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">
            <i class="fas fa-edit"></i> Edit Data Polyline
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit_polyline_id">

        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Jalur</label>
          <input type="text" name="name" id="edit_polyline_name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" id="edit_polyline_description" class="form-control" rows="2" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Upload Gambar Baru</label>
          <input type="file" name="image" class="form-control" accept="image/*" onchange="previewEditImage(event, 'edit_preview_polyline')">
          <img id="edit_preview_polyline" class="img-thumbnail mt-2" width="200" style="display:none;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">✏️ Update Polyline</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Polygon Modal -->
<div class="modal fade" id="modalEditPolygon">
  <div class="modal-dialog modal-lg">
    <form id="formEditPolygon" method="POST" enctype="multipart/form-data" class="modal-content shadow">
      @csrf
      @method('PUT')
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title">
            <i class="fas fa-edit"></i> Edit Data Polygon
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit_polygon_id">

        <div class="mb-3">
          <label class="form-label fw-semibold">Nama Area</label>
          <input type="text" name="name" id="edit_polygon_name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Deskripsi</label>
          <textarea name="description" id="edit_polygon_description" class="form-control" rows="2" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Upload Gambar Baru</label>
          <input type="file" name="image" class="form-control" accept="image/*" onchange="previewEditImage(event, 'edit_preview_polygon')">
          <img id="edit_preview_polygon" class="img-thumbnail mt-2" width="200" style="display:none;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning">✏️ Update Polygon</button>
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
function previewImage(event, previewId) {
    const file = event.target.files[0];
    const img = document.getElementById(previewId);

    if (file) {
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            alert('Hanya file JPG, JPEG, atau PNG yang diperbolehkan!');
            event.target.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB!');
            event.target.value = '';
            return;
        }

        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
    }
}

// ================= PREVIEW EDIT IMAGE =================
function previewEditImage(event, previewId) {
    const file = event.target.files[0];
    const img = document.getElementById(previewId);

    if (file) {
        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
    }
}

// ================= DELETE FUNCTION =================
function deleteData(type, id, name) {
    if (confirm(`Apakah Anda yakin ingin menghapus "${name}"?`)) {
        let url = '';
        if (type === 'points') {
            url = `/delete-points/${id}`;
        } else if (type === 'polylines') {
            url = `/delete-polylines/${id}`;
        } else if (type === 'polygons') {
            url = `/delete-polygons/${id}`;
        }

        $.ajax({
            url: url,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert('Data berhasil dihapus!');
                    location.reload();
                } else {
                    alert('Gagal menghapus data: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Terjadi kesalahan: ' + xhr.responseText);
            }
        });
    }
}

// ================= EDIT FUNCTION =================
function editData(type, id, name, description, image) {
    if (type === 'point') {
        $('#edit_point_id').val(id);
        $('#edit_point_name').val(name);
        $('#edit_point_description').val(description);
        $('#formEditPoint').attr('action', `/update-points/${id}`);
        $('#modalEditPoint').modal('show');
    } else if (type === 'polyline') {
        $('#edit_polyline_id').val(id);
        $('#edit_polyline_name').val(name);
        $('#edit_polyline_description').val(description);
        $('#formEditPolyline').attr('action', `/update-polylines/${id}`);
        $('#modalEditPolyline').modal('show');
    } else if (type === 'polygon') {
        $('#edit_polygon_id').val(id);
        $('#edit_polygon_name').val(name);
        $('#edit_polygon_description').val(description);
        $('#formEditPolygon').attr('action', `/update-polygons/${id}`);
        $('#modalEditPolygon').modal('show');
    }
}

// ================= FORMAT GEOMETRY FOR DISPLAY =================
function formatGeometry(geometry) {
    if (!geometry) return 'Tidak ada data geometry';

    // Coba parse jika geometry adalah string JSON
    let geomObj = geometry;
    if (typeof geometry === 'string') {
        try {
            geomObj = JSON.parse(geometry);
        } catch(e) {
            return geometry.substring(0, 100) + (geometry.length > 100 ? '...' : '');
        }
    }

    // Konversi ke WKT menggunakan Terraformer
    try {
        const wkt = Terraformer.geojsonToWKT(geomObj);
        return wkt;
    } catch(e) {
        return String(geometry).substring(0, 100);
    }
}

// ================= MAP INIT =================
const map = L.map('map').setView([-7.7956, 110.3695], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// ================= DRAW CONTROL =================
const drawnItems = new L.FeatureGroup();
map.addLayer(drawnItems);

const drawControl = new L.Control.Draw({
    draw: {
        polyline: {
            shapeOptions: {
                color: '#f357a1',
                weight: 5
            }
        },
        polygon: {
            shapeOptions: {
                color: '#f357a1',
                weight: 3
            }
        },
        rectangle: {
            shapeOptions: {
                color: '#f357a1',
                weight: 3
            }
        },
        marker: true,
        circle: false,
        circlemarker: false
    },
    edit: {
        featureGroup: drawnItems
    }
});

map.addControl(drawControl);

// ================= HANDLE DRAW CREATED =================
map.on('draw:created', function(e) {
    const type = e.layerType;
    const layer = e.layer;

    drawnItems.addLayer(layer);

    const geojson = layer.toGeoJSON();
    const wkt = Terraformer.geojsonToWKT(geojson.geometry);

    if (type === 'polyline') {
        document.getElementById('geometry_polyline').value = wkt;
        const modal = new bootstrap.Modal(document.getElementById('modalInputPolyline'));
        modal.show();
    } else if (type === 'polygon' || type === 'rectangle') {
        document.getElementById('geometry_polygon').value = wkt;
        const modal = new bootstrap.Modal(document.getElementById('modalInputPolygon'));
        modal.show();
    } else if (type === 'marker') {
        document.getElementById('geometry_point').value = wkt;
        const modal = new bootstrap.Modal(document.getElementById('modalInputPoint'));
        modal.show();
    }
});

// ================= LOAD POINTS WITH GEOMETRY IN POPUP =================
$.getJSON("{{ route('api.geojson_points') }}", function(data) {
    L.geoJSON(data, {
        pointToLayer: function(feature, latlng) {
            return L.marker(latlng);
        },
        onEachFeature: function(feature, layer) {
            const geometryWKT = formatGeometry(feature.geometry);
            const deleteBtn = `<button class="delete-btn" onclick="deleteData('points', ${feature.properties.id}, '${feature.properties.name.replace(/'/g, "\\'")}')">🗑️ Hapus Point</button>`;
            const editBtn = `<button class="edit-btn" onclick="editData('point', ${feature.properties.id}, '${feature.properties.name.replace(/'/g, "\\'")}', '${feature.properties.description ? feature.properties.description.replace(/'/g, "\\'") : ''}')">✏️ Edit Point</button>`;

            let popupContent = `
                <div style="min-width: 280px;">
                    <strong><i class="fas fa-map-marker-alt"></i> ${feature.properties.name}</strong><br>
                    <em>${feature.properties.description || 'Tidak ada deskripsi'}</em><br>
                    <div class="popup-geometry">
                        <div class="popup-geometry-label"><i class="fas fa-draw-polygon"></i> Geometry (WKT):</div>
                        <code style="font-size: 10px;">${geometryWKT}</code>
                    </div>
            `;

            if (feature.properties.image && feature.properties.image !== 'null') {
                popupContent += `<img src="/storage/images/${feature.properties.image}" width="180" class="mt-2"><br>`;
            }

            popupContent += `${editBtn}${deleteBtn}</div>`;
            layer.bindPopup(popupContent);
        }
    }).addTo(map);
}).fail(function() {
    console.log('Gagal memuat data points');
});

// ================= LOAD POLYLINES WITH GEOMETRY IN POPUP =================
$.getJSON("{{ route('api.geojson_polylines') }}", function(data) {
    L.geoJSON(data, {
        style: {
            color: '#0066ff',
            weight: 5,
            opacity: 0.8
        },
        onEachFeature: function(feature, layer) {
            const geometryWKT = formatGeometry(feature.geometry);
            const deleteBtn = `<button class="delete-btn" onclick="deleteData('polylines', ${feature.properties.id}, '${feature.properties.name.replace(/'/g, "\\'")}')">🗑️ Hapus Polyline</button>`;
            const editBtn = `<button class="edit-btn" onclick="editData('polyline', ${feature.properties.id}, '${feature.properties.name.replace(/'/g, "\\'")}', '${feature.properties.description ? feature.properties.description.replace(/'/g, "\\'") : ''}')">✏️ Edit Polyline</button>`;

            let popupContent = `
                <div style="min-width: 280px;">
                    <strong><i class="fas fa-chart-line"></i> ${feature.properties.name}</strong><br>
                    <em>${feature.properties.description || 'Tidak ada deskripsi'}</em><br>
                    <div class="popup-geometry">
                        <div class="popup-geometry-label"><i class="fas fa-draw-polygon"></i> Geometry (WKT):</div>
                        <code style="font-size: 10px;">${geometryWKT}</code>
                    </div>
            `;

            if (feature.properties.image && feature.properties.image !== 'null') {
                popupContent += `<img src="/storage/images/${feature.properties.image}" width="180" class="mt-2"><br>`;
            }

            popupContent += `${editBtn}${deleteBtn}</div>`;
            layer.bindPopup(popupContent);
        }
    }).addTo(map);
}).fail(function() {
    console.log('Gagal memuat data polylines');
});

// ================= LOAD POLYGONS WITH GEOMETRY IN POPUP =================
$.getJSON("{{ route('api.geojson_polygons') }}", function(data) {
    L.geoJSON(data, {
        style: {
            color: '#00cc66',
            weight: 3,
            fillColor: '#00cc66',
            fillOpacity: 0.3
        },
        onEachFeature: function(feature, layer) {
            const geometryWKT = formatGeometry(feature.geometry);
            const deleteBtn = `<button class="delete-btn" onclick="deleteData('polygons', ${feature.properties.id}, '${feature.properties.name.replace(/'/g, "\\'")}')">🗑️ Hapus Polygon</button>`;
            const editBtn = `<button class="edit-btn" onclick="editData('polygon', ${feature.properties.id}, '${feature.properties.name.replace(/'/g, "\\'")}', '${feature.properties.description ? feature.properties.description.replace(/'/g, "\\'") : ''}')">✏️ Edit Polygon</button>`;

            let popupContent = `
                <div style="min-width: 280px;">
                    <strong><i class="fas fa-draw-polygon"></i> ${feature.properties.name}</strong><br>
                    <em>${feature.properties.description || 'Tidak ada deskripsi'}</em><br>
                    <div class="popup-geometry">
                        <div class="popup-geometry-label"><i class="fas fa-draw-polygon"></i> Geometry (WKT):</div>
                        <code style="font-size: 10px;">${geometryWKT}</code>
                    </div>
            `;

            if (feature.properties.image && feature.properties.image !== 'null') {
                popupContent += `<img src="/storage/images/${feature.properties.image}" width="180" class="mt-2"><br>`;
            }

            popupContent += `${editBtn}${deleteBtn}</div>`;
            layer.bindPopup(popupContent);
        }
    }).addTo(map);
}).fail(function() {
    console.log('Gagal memuat data polygons');
});

// Clear drawn items after modal close
$('#modalInputPoint, #modalInputPolyline, #modalInputPolygon').on('hidden.bs.modal', function() {
    drawnItems.clearLayers();
});

// Tambahkan CSRF token ke semua AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
@endsection

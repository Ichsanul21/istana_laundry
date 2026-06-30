@php $isEdit = isset($branch); @endphp

<x-admin-layout>
    <x-slot:title>{{ $isEdit ? 'Edit Cabang' : 'Tambah Cabang' }}</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit Cabang' : 'Tambah Cabang' }}</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a>
                </li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li>
                    <a href="{{ route('admin.branches.index') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Cabang</a>
                </li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">{{ $isEdit ? 'Edit' : 'Tambah' }}</li>
            </ol>
        </nav>
    </div>

    <form action="{{ $isEdit ? route('admin.branches.update', $branch) : route('admin.branches.store') }}" method="POST">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-ui.card title="Informasi Cabang">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input label="Nama Cabang" name="name" :value="old('name', $branch->name ?? '')" required />
                        <x-form.select label="Tipe" name="type" :options="['workshop' => 'Workshop', 'cabang' => 'Cabang']" :value="old('type', $branch->type ?? 'cabang')" required />
                    </div>

                    <div class="mt-4">
                        <x-form.textarea label="Alamat" name="address" :value="old('address', $branch->address ?? '')" :rows="3" required />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <x-form.input label="No. Telepon" name="phone" :value="old('phone', $branch->phone ?? '')" placeholder="08xx-xxxx-xxxx" />
                        <x-form.input label="Jam Operasional" name="open_hours" :value="old('open_hours', $branch->open_hours ?? '')" placeholder="08:00 - 20:00" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <x-form.input label="Latitude" name="lat" type="number" step="0.0000001" :value="old('lat', $branch->lat ?? '-0.4869703')" required />
                        <x-form.input label="Longitude" name="lng" type="number" step="0.0000001" :value="old('lng', $branch->lng ?? '117.1292781')" required />
                        <x-form.input label="Radius (km)" name="radius_km" type="number" step="0.5" min="0.5" max="10" :value="old('radius_km', $branch->radius_km ?? '3')" required />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <x-form.input label="Urutan" name="sort_order" type="number" min="0" :value="old('sort_order', $branch->sort_order ?? 0)" />
                        <div class="flex items-end">
                            <x-form.checkbox label="Aktif" name="is_active" :checked="old('is_active', $branch->is_active ?? true)" />
                        </div>
                    </div>
                </x-ui.card>
            </div>

            <div class="space-y-6">
                <x-ui.card title="Lokasi di Peta">
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400 mb-3">Klik pada peta untuk menentukan koordinat.</p>
                    <div id="map" style="height: 300px; border-radius: 12px; z-index: 1;"></div>
                </x-ui.card>

                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/>
                        </svg>
                        {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Cabang' }}
                    </button>
                    <a href="{{ route('admin.branches.index') }}" class="inline-flex items-center px-5 py-3 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const defaultLat = {{ old('lat', $branch->lat ?? -0.4869703) }};
            const defaultLng = {{ old('lng', $branch->lng ?? 117.1292781) }};
            const defaultRadius = {{ old('radius_km', $branch->radius_km ?? 3) }};

            const map = L.map('map').setView([defaultLat, defaultLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
            const circle = L.circle([defaultLat, defaultLng], {
                radius: defaultRadius * 1000,
                color: '#FF6B00',
                fillColor: '#FF6B00',
                fillOpacity: 0.1,
                weight: 2
            }).addTo(map);

            const latInput = document.querySelector('input[name="lat"]');
            const lngInput = document.querySelector('input[name="lng"]');
            const radiusInput = document.querySelector('input[name="radius_km"]');

            map.on('click', function (e) {
                const { lat, lng } = e.latlng;
                marker.setLatLng([lat, lng]);
                circle.setLatLng([lat, lng]);
                latInput.value = lat.toFixed(7);
                lngInput.value = lng.toFixed(7);
            });

            marker.on('dragend', function (e) {
                const { lat, lng } = marker.getLatLng();
                circle.setLatLng([lat, lng]);
                latInput.value = lat.toFixed(7);
                lngInput.value = lng.toFixed(7);
            });

            radiusInput.addEventListener('input', function () {
                circle.setRadius(parseFloat(this.value) * 1000);
            });
        });
    </script>
    @endpush
</x-admin-layout>

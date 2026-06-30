<x-admin-layout>
    <x-slot:title>Detail Pengecekan</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Detail Pengecekan Lokasi</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a>
                </li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li>
                    <a href="{{ route('admin.location-checks.index') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Pengecekan Lokasi</a>
                </li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-ui.card title="Peta Lokasi">
                <div id="map" style="height: 400px; border-radius: 12px; z-index: 1;"></div>
            </x-ui.card>

            <x-ui.card title="Informasi Pelanggan">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">Nama</span>
                        <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $locationCheck->name }}</p>
                    </div>
                    <div>
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">WhatsApp</span>
                        <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $locationCheck->whatsapp) }}" target="_blank" class="text-brand-500 hover:underline">{{ $locationCheck->whatsapp }}</a>
                        </p>
                    </div>
                    <div>
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">Email</span>
                        <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $locationCheck->email ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">Tanggal Pengecekan</span>
                        <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $locationCheck->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <span class="text-theme-xs text-gray-500 dark:text-gray-400">Alamat</span>
                        <p class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $locationCheck->address }}</p>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <div class="space-y-6">
            <x-ui.card title="Hasil Pengecekan">
                <div class="text-center py-4">
                    @if($locationCheck->is_within_radius)
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-success-50 dark:bg-success-950/30 flex items-center justify-center">
                            <svg class="w-8 h-8 text-success-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <x-ui.badge color="success" size="md">Dalam Jangkauan</x-ui.badge>
                    @else
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-error-50 dark:bg-error-950/30 flex items-center justify-center">
                            <svg class="w-8 h-8 text-error-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                            </svg>
                        </div>
                        <x-ui.badge color="error" size="md">Di Luar Jangkauan</x-ui.badge>
                    @endif
                </div>

                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-800">
                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">Jarak</span>
                        <span class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ number_format($locationCheck->distance_km, 2) }} km</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-800">
                        <span class="text-theme-sm text-gray-500 dark:text-gray-400">Koordinat</span>
                        <span class="text-theme-xs font-mono text-gray-600 dark:text-gray-400">{{ number_format($locationCheck->lat, 7) }}, {{ number_format($locationCheck->lng, 7) }}</span>
                    </div>
                    @if($locationCheck->nearestBranch)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-800">
                            <span class="text-theme-sm text-gray-500 dark:text-gray-400">Cabang Terdekat</span>
                            <span class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $locationCheck->nearestBranch->name }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-theme-sm text-gray-500 dark:text-gray-400">Radius Cabang</span>
                            <span class="text-theme-sm font-medium text-gray-800 dark:text-white/90">{{ $locationCheck->nearestBranch->radius_km }} km</span>
                        </div>
                    @endif
                </div>
            </x-ui.card>

            <a href="{{ route('admin.location-checks.index') }}" class="inline-flex items-center gap-2 px-5 py-3 text-theme-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkLat = {{ $locationCheck->lat }};
            const checkLng = {{ $locationCheck->lng }};

            const map = L.map('map').setView([checkLat, checkLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const userMarker = L.marker([checkLat, checkLng]).addTo(map);
            userMarker.bindPopup('<b>{{ $locationCheck->name }}</b><br>{{ $locationCheck->address }}').openPopup();

            @if($locationCheck->nearestBranch)
                const branchLat = {{ $locationCheck->nearestBranch->lat }};
                const branchLng = {{ $locationCheck->nearestBranch->lng }};
                const branchRadius = {{ $locationCheck->nearestBranch->radius_km }} * 1000;

                const branchMarker = L.marker([branchLat, branchLng], {
                    icon: L.divIcon({
                        className: 'custom-branch-icon',
                        html: '<div style="background:#FF6B00;color:white;width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;border:2px solid white;box-shadow:0 2px 6px rgba(0,0,0,0.3);"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg></div>',
                        iconSize: [30, 30],
                        iconAnchor: [15, 15]
                    })
                }).addTo(map);
                branchMarker.bindPopup('<b>{{ $locationCheck->nearestBranch->name }}</b>');

                L.circle([branchLat, branchLng], {
                    radius: branchRadius,
                    color: '#FF6B00',
                    fillColor: '#FF6B00',
                    fillOpacity: 0.1,
                    weight: 2,
                    dashArray: '5, 5'
                }).addTo(map);

                L.polyline([[checkLat, checkLng], [branchLat, branchLng]], {
                    color: '#999',
                    weight: 2,
                    dashArray: '5, 5'
                }).addTo(map);

                map.fitBounds([
                    [checkLat, checkLng],
                    [branchLat, branchLng]
                ], { padding: [50, 50] });
            @endif
        });
    </script>
    @endpush
</x-admin-layout>

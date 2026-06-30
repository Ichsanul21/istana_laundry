<x-admin-layout>
    <x-slot:title>Pengaturan Umum</x-slot:title>

    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Pengaturan Umum</h2>
        <nav>
            <ol class="flex items-center gap-1.5">
                <li><a href="{{ route('admin.dashboard') }}" class="text-theme-sm text-gray-500 dark:text-gray-400 hover:text-brand-500">Home</a></li>
                <li class="text-theme-sm text-gray-500 dark:text-gray-400">/</li>
                <li class="text-theme-sm text-gray-800 dark:text-white/90">Pengaturan</li>
            </ol>
        </nav>
    </div>

    @if(session('success'))
        <x-ui.alert type="success" :dismissible="true">{{ session('success') }}</x-ui.alert>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <x-ui.card title="Informasi Perusahaan">
                <x-form.input label="Nama Perusahaan" name="company_name" :value="old('company_name', $settings['company_name']->value ?? '')" />
                <div class="mt-4">
                    <x-form.input label="Tagline" name="company_tagline" :value="old('company_tagline', $settings['company_tagline']->value ?? '')" />
                </div>
                <div class="mt-4">
                    <x-form.textarea label="Alamat" name="company_address" :value="old('company_address', $settings['company_address']->value ?? '')" :rows="2" />
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <x-form.input label="Telepon" name="company_phone" :value="old('company_phone', $settings['company_phone']->value ?? '')" />
                    <x-form.input label="Email" name="company_email" type="email" :value="old('company_email', $settings['company_email']->value ?? '')" />
                </div>
            </x-ui.card>

            <x-ui.card title="WhatsApp">
                <x-form.input label="WA Center" name="wa_center" :value="old('wa_center', $settings['wa_center']->value ?? '')" hint="Nomor WhatsApp utama" />
                <div class="mt-4">
                    <x-form.input label="WA Gatot Subroto" name="wa_gatot_subroto" :value="old('wa_gatot_subroto', $settings['wa_gatot_subroto']->value ?? '')" hint="Nomor WA cabang Gatot Subroto" />
                </div>
            </x-ui.card>

            <x-ui.card title="SEO Default" class="lg:col-span-2">
                <x-form.input label="Default Meta Title" name="default_meta_title" :value="old('default_meta_title', $settings['default_meta_title']->value ?? '')" hint="Maks 70 karakter" />
                <div class="mt-4">
                    <x-form.textarea label="Default Meta Description" name="default_meta_description" :value="old('default_meta_description', $settings['default_meta_description']->value ?? '')" :rows="2" hint="Maks 160 karakter" />
                </div>
            </x-ui.card>
        </div>

        <div class="flex items-center gap-3 mt-6">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 text-theme-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l6 6 9-13.5"/></svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</x-admin-layout>

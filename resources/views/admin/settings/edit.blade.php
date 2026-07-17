@extends('admin.layouts.app')

@section('title', 'Edit Pengaturan Website')

@section('content')

    <div class="max-w-7xl mx-auto space-y-6">


        {{-- HEADER --}}
        <div class="bg-white rounded-2xl shadow p-6">

            <h1 class="text-3xl font-bold flex items-center gap-3">
                <i class="fa-solid fa-gear text-primary-600"></i>
                Pengaturan Website
            </h1>

            <p class="text-gray-500 mt-2">
                Kelola semua informasi website sekolah
            </p>

        </div>



        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl">
                {{ session('success') }}
            </div>
        @endif




        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">


            @csrf
            @method('PUT')




            {{-- PROFIL SEKOLAH --}}

            <div class="bg-white rounded-2xl shadow p-6">

                <h2 class="text-xl font-bold mb-5 flex gap-2">
                    <i class="fa-solid fa-school text-primary-600"></i>
                    Profil Sekolah
                </h2>


                <div class="space-y-5">


                    <div>
                        <label class="font-semibold">
                            Profil Sekolah
                        </label>

                        <textarea name="profil_sekolah" rows="5" class="w-full border rounded-xl p-3 mt-2" placeholder="Tuliskan profil sekolah">

{{ old('profil_sekolah', $settings['profil_sekolah'] ?? '') }}

</textarea>

                    </div>



                    <div>

                        <label class="font-semibold">
                            Sambutan Kepala Sekolah
                        </label>


                        <textarea name="sambutan_kepsek" rows="5" class="w-full border rounded-xl p-3 mt-2" placeholder="Tuliskan sambutan kepala sekolah">

{{ old('sambutan_kepsek', $settings['sambutan_kepsek'] ?? '') }}

</textarea>


                    </div>




                    <div class="grid md:grid-cols-2 gap-5">


                        <div>

                            <label class="font-semibold">
                                Visi
                            </label>


                            <textarea name="visi" rows="4" class="w-full border rounded-xl p-3 mt-2" placeholder="Tuliskan visi sekolah">

{{ old('visi', $settings['visi'] ?? '') }}

</textarea>

                        </div>



                        <div>

                            <label class="font-semibold">
                                Misi
                            </label>


                            <textarea name="misi" rows="4" class="w-full border rounded-xl p-3 mt-2" placeholder="Tuliskan misi sekolah">

{{ old('misi', $settings['misi'] ?? '') }}

</textarea>

                        </div>


                    </div>


                </div>

            </div>






            {{-- KONTAK --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5">
                    <i class="fa-solid fa-phone text-green-600"></i>
                    Kontak Sekolah
                </h2>


                <div class="grid md:grid-cols-2 gap-5">


                    <div>

                        <label>Email</label>

                        <input type="email" name="email" value="{{ old('email', $settings['email'] ?? '') }}"
                            placeholder="admin@sekolah.sch.id"
                            class="w-full border rounded-xl p-3 mt-2">

                    </div>




                    <div>

                        <label>Telepon</label>

                        <input type="text" name="telepon" value="{{ old('telepon', $settings['telepon'] ?? '') }}"
                            placeholder="Contoh: 021-1234567"
                            class="w-full border rounded-xl p-3 mt-2">

                    </div>


                </div>



                <div class="mt-5">

                    <label>Alamat</label>


                    <input type="text" name="alamat" value="{{ old('alamat', $settings['alamat'] ?? '') }}"
                        placeholder="Masukkan alamat sekolah"
                        class="w-full border rounded-xl p-3 mt-2">


                </div>


                <div class="mt-5">

                    <label>Jam Operasional</label>

                    <input type="text" name="jam_operasional" value="{{ old('jam_operasional', $settings['jam_operasional'] ?? '') }}"
                        placeholder="Senin - Jumat 07:00 - 14:00"
                        class="w-full border rounded-xl p-3 mt-2">

                    <p class="text-xs text-gray-400 mt-1">Contoh: Senin - Jumat 07:00 - 14:00</p>

                </div>


            </div>






            {{-- KEPALA SEKOLAH --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5">
                    <i class="fa-solid fa-user-tie text-purple-600"></i>
                    Kepala Sekolah
                </h2>


                <input type="text" name="nama_kepsek" value="{{ old('nama_kepsek', $settings['nama_kepsek'] ?? '') }}"
                    placeholder="Nama Kepala Sekolah" class="w-full border rounded-xl p-3">


            </div>






            {{-- MEDIA --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5">
                    <i class="fa-solid fa-image text-orange-600"></i>
                    Media Website
                </h2>



                <div class="grid md:grid-cols-2 gap-6">


                    <div>

                        <label>Foto Profil</label>

                        <input type="file" name="profil_image" class="w-full border rounded-xl p-3 mt-2">


                        @if (!empty($settings['profil_image']))
                            <img src="{{ asset('storage/settings/' . $settings['profil_image']) }}"
                                class="mt-4 w-48 rounded-xl">
                        @endif


                    </div>



                    <div>

                        <label>Foto Kepala Sekolah</label>

                        <input type="file" name="hero_image" class="w-full border rounded-xl p-3 mt-2">


                        @if (!empty($settings['hero_image']))
                            <img src="{{ asset('storage/settings/' . $settings['hero_image']) }}"
                                class="mt-4 w-full h-40 object-cover rounded-xl">
                        @endif


                    </div>



                </div>


            </div>







            {{-- IDENTITAS WEBSITE --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5">
                    <i class="fa-solid fa-globe text-primary-600"></i>
                    Identitas Website
                </h2>



                <div class="grid md:grid-cols-2 gap-5">


                    <div>
                        <label>Nama Sekolah:</label>

                        <input name="nama_sekolah" value="{{ $settings['nama_sekolah'] ?? '' }}" placeholder="Masukkan nama sekolah" class="input">

                    </div>


                    <div>

                        <label>Nama Website:</label>

                        <input name="nama_website" value="{{ $settings['nama_website'] ?? '' }}" placeholder="Masukkan nama website" class="input">

                    </div>



                    <div>

                        <label>Tagline:</label>

                        <input name="tagline" value="{{ $settings['tagline'] ?? '' }}" placeholder="Masukkan tagline sekolah" class="input">

                    </div>

                    <div>

                        <label>Akreditasi:</label>

                        <select name="akreditasi" class="input">
                            @foreach (['A' => 'A (Unggul)', 'B' => 'B (Sangat Baik)', 'C' => 'C (Baik)', 'D' => 'D (Memadai)'] as $val => $label)
                                <option value="{{ $val }}" {{ ($settings['akreditasi'] ?? 'A') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                    </div>



                </div>


            </div>



            {{-- WARNA TEMA --}}
            @php
                $currentColor = $settings['primary_color'] ?? '#2563eb';
                $presetColors = [
                    '#2563eb' => 'Biru',
                    '#16a34a' => 'Hijau',
                    '#dc2626' => 'Merah',
                    '#9333ea' => 'Ungu',
                    '#4f46e5' => 'Indigo',
                    '#0d9488' => 'Teal',
                    '#ea580c' => 'Oranye',
                    '#ca8a04' => 'Kuning',
                    '#0891b2' => 'Cyan',
                    '#6d28d9' => 'Violet',
                ];
            @endphp

            <div class="bg-white rounded-2xl shadow p-6" id="colorPickerSection">

                <h2 class="text-xl font-bold mb-5">
                    <i class="fa-solid fa-palette text-pink-600"></i>
                    Warna Tema Website
                </h2>

                <p class="text-xs text-gray-500 mb-5">
                    Pilih warna utama yang digunakan di seluruh website publik (navbar, tombol, badge, link, dll).
                </p>

                {{-- Preset Colors --}}
                <div class="mb-5">
                    <label class="font-semibold text-sm mb-3 block">Pilihan Warna</label>
                    <div class="flex flex-wrap gap-2" id="presetColors">
                        @foreach ($presetColors as $hex => $name)
                            <button type="button"
                                class="w-9 h-9 rounded-xl border-2 transition-all hover:scale-110 preset-btn {{ $hex === $currentColor ? 'ring-2 ring-offset-2 ring-slate-800' : '' }}"
                                style="background-color: {{ $hex }}; border-color: {{ $hex === $currentColor ? '#1e293b' : 'transparent' }};"
                                title="{{ $name }}"
                                data-color="{{ $hex }}">
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Custom Color Picker --}}
                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="font-semibold text-sm mb-2 block">Pilih dari Palette</label>
                        <div class="flex items-center gap-3">
                            <input type="color" id="colorPickerNative" value="{{ $currentColor }}"
                                class="w-14 h-10 rounded-lg cursor-pointer border-0 p-0">
                            <span class="text-sm font-mono text-gray-600" id="colorLabel">{{ $currentColor }}</span>
                        </div>
                    </div>

                    <div>
                        <label class="font-semibold text-sm mb-2 block">Kode Hex</label>
                        <input type="text" id="hexInput" name="primary_color" value="{{ $currentColor }}"
                            placeholder="#2563eb" maxlength="7"
                            class="input font-mono"
                            pattern="^#[0-9A-Fa-f]{6}$">
                    </div>
                </div>

                {{-- Preview --}}
                <div class="mt-5 p-4 rounded-xl border border-gray-200 bg-gray-50">
                    <label class="font-semibold text-sm mb-3 block">Preview</label>
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-4 py-2 rounded-xl text-white text-xs font-bold shadow" id="previewBtn">Tombol Utama</span>
                        <span class="px-4 py-2 rounded-xl text-xs font-bold border" id="previewBadge">Badge Label</span>
                        <span class="text-xs font-bold" id="previewLink">Teks Link</span>
                        <span class="w-8 h-8 rounded-full border-2" id="previewCircle"></span>
                    </div>
                </div>

            </div>

            @php
                $socials = json_decode($settings['social_media'] ?? '[]', true);
                if (!is_array($socials)) $socials = [];
            @endphp

            @section('scripts')
            <script>
                (function() {
                    var hexInput = document.getElementById('hexInput');
                    var nativePicker = document.getElementById('colorPickerNative');
                    var colorLabel = document.getElementById('colorLabel');
                    var presetBtns = document.querySelectorAll('.preset-btn');

                    function updateColor(hex) {
                        hex = hex.toLowerCase();
                        hexInput.value = hex;
                        nativePicker.value = hex;
                        colorLabel.textContent = hex;

                        document.getElementById('previewBtn').style.backgroundColor = hex;
                        var badge = document.getElementById('previewBadge');
                        badge.style.color = hex;
                        badge.style.borderColor = hex;
                        badge.style.backgroundColor = hex + '15';
                        document.getElementById('previewLink').style.color = hex;
                        var circle = document.getElementById('previewCircle');
                        circle.style.backgroundColor = hex + '15';
                        circle.style.borderColor = hex;

                        presetBtns.forEach(function(btn) {
                            if (btn.dataset.color.toLowerCase() === hex) {
                                btn.classList.add('ring-2', 'ring-offset-2', 'ring-slate-800');
                                btn.style.borderColor = '#1e293b';
                            } else {
                                btn.classList.remove('ring-2', 'ring-offset-2', 'ring-slate-800');
                                btn.style.borderColor = 'transparent';
                            }
                        });
                    }

                    nativePicker.addEventListener('input', function() {
                        updateColor(this.value);
                    });

                    hexInput.addEventListener('input', function() {
                        var val = this.value;
                        if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                            updateColor(val);
                        }
                    });

                    presetBtns.forEach(function(btn) {
                        btn.addEventListener('click', function() {
                            updateColor(this.dataset.color);
                        });
                    });

                    updateColor('{{ $currentColor }}');
                })();
            </script>
            <script>
                var socialIndex = {{ count($socials) }};

                function addSocial() {
                    var wrapper = document.getElementById('social-wrapper');
                    var html = '<div class="grid grid-cols-12 gap-3 items-center social-row">' +
                        '<input type="hidden" name="social_media_order[]" value="' + socialIndex + '">' +
                        '<div class="col-span-3">' +
                        '<input name="social_media[' + socialIndex + '][name]" value="" placeholder="Nama (contoh: Instagram)" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-primary-200 focus:border-primary-400">' +
                        '</div>' +
                        '<div class="col-span-4">' +
                        '<input name="social_media[' + socialIndex + '][icon]" value="" placeholder="Icon FA (contoh: fa-brands fa-instagram)" class="w-full border rounded-lg px-3 py-2 text-sm font-mono focus:ring focus:ring-primary-200 focus:border-primary-400">' +
                        '</div>' +
                        '<div class="col-span-4">' +
                        '<input name="social_media[' + socialIndex + '][url]" value="" placeholder="https://..." class="w-full border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-primary-200 focus:border-primary-400">' +
                        '</div>' +
                        '<div class="col-span-1 flex justify-center">' +
                        '<button type="button" onclick="removeSocial(this)" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-600 flex items-center justify-center transition">' +
                        '<i class="fa-solid fa-trash-can text-xs"></i>' +
                        '</button>' +
                        '</div>' +
                        '</div>';
                    wrapper.insertAdjacentHTML('beforeend', html);
                    socialIndex++;
                }

                function removeSocial(btn) {
                    btn.closest('.social-row').remove();
                }
            </script>
            @endsection






            {{-- LOGO --}}

            <div class="bg-white rounded-2xl shadow p-6">


                <h2 class="text-xl font-bold mb-5">
                    <i class="fa-solid fa-image text-red-600"></i>
                    Logo Website
                </h2>



                <div class="grid md:grid-cols-2 gap-6">


                    <div>

                        <label>Logo</label>

                        <input type="file" name="logo" class="input">


                    </div>


                    <div>

                        <label>Favicon</label>

                        <input type="file" name="favicon" class="input">


                    </div>



                </div>


            </div>







            {{-- SOSIAL MEDIA --}}

            <div class="bg-white rounded-2xl shadow p-6">

                <h2 class="text-xl font-bold mb-2">
                    <i class="fa-solid fa-share-nodes text-primary-600"></i>
                    Sosial Media
                </h2>

                <p class="text-xs text-gray-500 mb-5">
                    Contoh icon: <code class="bg-gray-100 px-1 rounded">fa-brands fa-instagram</code>,
                    <code class="bg-gray-100 px-1 rounded">fa-brands fa-facebook</code>,
                    <code class="bg-gray-100 px-1 rounded">fa-brands fa-youtube</code>,
                    <code class="bg-gray-100 px-1 rounded">fa-brands fa-tiktok</code>
                </p>

                <div id="social-wrapper" class="space-y-3">
                    @foreach ($socials as $i => $item)
                        <div class="grid grid-cols-12 gap-3 items-center social-row">
                            <input type="hidden" name="social_media_order[]" value="{{ $i }}">
                            <div class="col-span-3">
                                <input name="social_media[{{ $i }}][name]" value="{{ $item['name'] ?? '' }}"
                                    placeholder="Nama (contoh: Instagram)"
                                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-primary-200 focus:border-primary-400">
                            </div>
                            <div class="col-span-4">
                                <input name="social_media[{{ $i }}][icon]" value="{{ $item['icon'] ?? '' }}"
                                    placeholder="Icon FA (contoh: fa-brands fa-instagram)"
                                    class="w-full border rounded-lg px-3 py-2 text-sm font-mono focus:ring focus:ring-primary-200 focus:border-primary-400">
                            </div>
                            <div class="col-span-4">
                                <input name="social_media[{{ $i }}][url]" value="{{ $item['url'] ?? '' }}"
                                    placeholder="https://..."
                                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-primary-200 focus:border-primary-400">
                            </div>
                            <div class="col-span-1 flex justify-center">
                                <button type="button" onclick="removeSocial(this)"
                                    class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 hover:text-red-600 flex items-center justify-center transition">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" onclick="addSocial()"
                    class="mt-4 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg text-sm flex items-center gap-2 transition">
                    <i class="fa-solid fa-plus text-xs"></i> Tambah Sosial Media
                </button>

            </div>







            {{-- ACTION --}}

            <div class="bg-white rounded-2xl shadow p-6 flex gap-3">


                <button class="bg-primary-600 text-white px-6 py-3 rounded-xl">

                    <i class="fa fa-save"></i>
                    Simpan

                </button>



                <a href="{{ route('admin.settings.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-xl">

                    Batal

                </a>


            </div>




        </form>


    </div>




    <style>
        .input {
            @apply w-full border rounded-xl p-3 mt-2;
        }
    </style>


@endsection

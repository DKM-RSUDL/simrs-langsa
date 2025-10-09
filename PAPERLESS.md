# PAPERLESS TEAM RSUD LANGSA

# Komponen
### 1. `page-header`
**Lokasi:** `resources/views/components/page-header.blade.php`  
**Fungsi:** Menampilkan judul dan deskripsi halaman secara konsisten di seluruh aplikasi.
#### 📘 Penggunaan
```blade
@include('components.page-header', [
    'title' => 'Masukkan judul',
    'description' => 'Masukkan deskripsi halaman.',
])
```

### 2. `button-previous`
**Lokasi:** `resources/views/components/button-previous.blade.php`  
**Fungsi:** Membuat tombol kembali untuk disetiap halaman.
```blade
@props([
    'href' => url()->previous(),
    'class' => 'btn btn-outline-secondary w-min d-flex align-items-center gap-2',
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
    <i class="ti-arrow-left"></i>
   {{ $slot->isEmpty() ? 'Kembali' : $slot }}
</a>
```

### 3. `content-card`
**Lokasi:** `resources/views/components/content-card.blade.php`  
**Fungsi:** Membuat body content untuk semua halaman.
```blade
@props([
    'class' => 'card h-auto',
    'bodyClass' => 'card-body d-flex flex-column gap-4',
])

<div {{ $attributes->merge(['class' => $class]) }}>
    <div class="{{ $bodyClass }}">
        {{ $slot }}
    </div>
</div>
```


© 2025 — **PaperlessHospital.id**  
_Dikembangkan oleh Tim IT RSUD Langsa_



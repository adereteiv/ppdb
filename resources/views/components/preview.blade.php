<div class="inputbox align-items-start">
    @if (Str::endsWith($dokumen->file_path, ['.jpg', '.jpeg', '.png']))
        <img src="{{ asset('storage/' . $dokumen->file_path) }}" alt="Preview" class="preview-image" onclick="openModal('{{ asset('storage/' . $dokumen->file_path) }}')" style="width: 100px; height: auto; cursor: pointer; border: 1px solid #ddd; padding: 5px;">
    @elseif (Str::endsWith($dokumen->file_path, ['.pdf']))
        <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank">Lihat PDF</a>
    @endif
</div>

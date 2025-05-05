@forelse($data as $entry)
    <tr>
        {{-- Use $data as memberi numerasi based on the whole collection, not as a single [$data as $entry] item in the looping --}}
        <td>{{ $data->firstItem() + $loop->index }}</td>
        <td>{{ ($entry->jadwal_posting)->translatedFormat('d F Y') }}</td>
        <td>
            <p><strong>{{ $entry->judul }}</strong></p>
            <p>
                {{ $entry->keterangan }}
            </p>
        </td>
        <td><a href="{{ $entry->file_path }}"></a></td>
        <td>
            <div class="flex justify-center">
                <button class="tombol tombol-netral tooltip" tooltip="top" data-url="{{ route('admin.pengumuman.show', $entry->id) }}">
                    <span class="tooltiptext">Lihat</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="18" width="18"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                </button>
                <form action="{{ route('admin.pengumuman.destroy', $entry->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')"> @csrf @method('DELETE')
                    <button type="submit" class="tombol tombol-negatif tooltip" tooltip="top">
                        <span class="tooltiptext">Hapus</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="18" width="18"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr><td colspan="5">Data tidak ditemukan.</td></tr>
@endforelse

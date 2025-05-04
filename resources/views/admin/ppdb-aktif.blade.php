@forelse($data as $entry)
    <tr>
        {{-- Use $data as memberi numerasi based on the whole collection, not as a single [$data as $entry] item in the looping --}}
        <td>{{ $data->firstItem() + $loop->index }}</td>
        <td>{{ ($entry->created_at)->translatedFormat('d F Y') }}</td>
        <td>{{ $entry->id }}</td>
        <td>{{ $entry->infoAnak?->nama_anak ?? 'null' }}</td>
        <td><x-status-pendaftaran :value="$entry->status ?? null"/></td>
        <td>
            <div class="flex justify-center">
                <button class="tombol tombol-netral tooltip" tooltip="top" data-url="{{ route('ppdb.aktif.show', $entry->id) }}">
                    <span class="tooltiptext">Lihat</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="18" width="18"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                </button>
                <a href="{{ route('ppdb.aktif.edit', $entry->id) }}" class="tombol tombol-netral tooltip" tooltip="top">
                    <span class="tooltiptext">Edit</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="18" width="18"><path d="M160-400v-80h280v80H160Zm0-160v-80h440v80H160Zm0-160v-80h440v80H160Zm360 560v-123l221-220q9-9 20-13t22-4q12 0 23 4.5t20 13.5l37 37q8 9 12.5 20t4.5 22q0 11-4 22.5T863-380L643-160H520Zm300-263-37-37 37 37ZM580-220h38l121-122-18-19-19-18-122 121v38Zm141-141-19-18 37 37-18-19Z"/></svg>
                </a>
                <form action="{{ route('ppdb.aktif.destroy', $entry->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')"> @csrf @method('DELETE')
                    <button type="submit" class="tombol tombol-negatif tooltip" tooltip="top">
                        <span class="tooltiptext">Hapus</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="18" width="18"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr><td colspan="6">Data tidak ditemukan.</td></tr>
@endforelse

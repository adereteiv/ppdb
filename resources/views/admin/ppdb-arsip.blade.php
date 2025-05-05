@forelse($data as $entry)
    <tr>
        <td>{{ $data->firstItem() + $loop->index }}</td>
        <td>{{ ($entry->created_at)->translatedFormat('d F Y') }}</td>
        <td>{{ $entry->id }}</td>
        <td>{{ $entry->infoAnak?->nama_anak ?? 'null' }}</td>
        <td><x-status-pendaftaran :value="$entry->status ?? null"/></td>
        <td>
            <div class="flex justify-center">
                <div class="flex justify-center">
                    <button class="tombol tombol-netral tooltip" tooltip="top" data-url="{{ route('admin.ppdb.arsip.show', $entry->id) }}">
                        <span class="tooltiptext">Lihat</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" height="18" width="18"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>
                    </button>
                </div>
            </div>
        </td>
    </tr>
@empty
    <tr><td colspan="6">Data tidak ditemukan.</td></tr>
@endforelse

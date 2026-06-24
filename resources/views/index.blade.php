<h1>Daftar Bahan Baku SPPG Paku Jaya</h1>
<table border="1">
    <thead>
        <tr>
            <th>Nama Bahan</th>
            <th>Kategori</th>
            <th>Satuan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($materials as $m)
        <tr>
            <td>{{ $m->name }}</td>
            <td>{{ $m->category->name ?? 'Tanpa Kategori' }}</td>
            <td>{{ $m->unit }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

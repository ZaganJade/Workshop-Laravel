<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Katalog Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Katalog Buku Perpustakaan</h2>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 15%;">Signatur Kode</th>
                <th style="width: 35%;">Judul Buku</th>
                <th style="width: 25%;">Pengarang</th>
                <th style="width: 20%;">Klasifikasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buku as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->pengarang }}</td>
                <td>{{ $item->kategori->nama_kategori ?? 'Umum' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

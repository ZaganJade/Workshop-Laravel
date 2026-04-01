<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Label Barang — Print</title>
    <style>
        @page {
            margin: 8mm;
            size: A4 portrait;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            color: #1e293b;
            background: #ffffff;
        }

        .page {
            page-break-after: always;
            width: 100%;
        }
        .page:last-child {
            page-break-after: auto;
        }

        table {
            width: 100%;
            height: 281mm; /* A4 = 297mm - 16mm margin */
            border-collapse: collapse;
            table-layout: fixed;
        }

        td {
            width: 20%;
            height: 12.5%;
            vertical-align: middle;
            text-align: center;
            padding: 4px 6px;
            overflow: hidden;
            border: 0.5pt solid #e2e8f0;
        }

        /* =============================== */
        /* Label Card Style                */
        /* =============================== */
        .label-card {
            display: inline-block;
            width: 92%;
            padding: 8px 6px 10px 6px;
            border: 1.5pt solid #0f172a;
            border-radius: 8px;
            background: #ffffff;
            text-align: center;
        }

        .label-nama {
            font-size: 11px;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.3;
            margin-bottom: 4px;
            word-wrap: break-word;
            overflow: hidden;
        }

        .label-divider {
            width: 50%;
            height: 1.5pt;
            background-color: #10b981;
            margin: 0 auto 5px auto;
            border: none;
            border-radius: 2px;
        }

        .label-harga {
            font-size: 16px;
            font-weight: 800;
            color: #059669;
            letter-spacing: 0.3px;
            line-height: 1;
        }

        .label-currency {
            font-size: 9px;
            font-weight: 600;
            color: #6b7280;
            vertical-align: top;
            margin-right: 1px;
        }

        /* Empty slot styling */
        td.empty-slot {
            border: 0.5pt dashed #e5e7eb;
            background: #fafafa;
        }
    </style>
</head>
<body>
    @foreach($pages as $pageIndex => $page)
        <div class="page">
            <table>
            @for($r = 0; $r < 8; $r++)
                <tr>
                @for($c = 0; $c < 5; $c++)
                    @php
                        $index = $r * 5 + $c;
                        $item = $page[$index] ?? null;
                    @endphp

                    @if($item)
                        <td>
                            <div class="label-card">
                                <div class="label-nama">{{ $item->nama }}</div>
                                <div class="label-divider"></div>
                                <div class="label-harga">
                                    <span class="label-currency">Rp</span>{{ number_format($item->harga, 0, ',', '.') }}
                                </div>
                            </div>
                        </td>
                    @else
                        <td class="empty-slot">&nbsp;</td>
                    @endif
                @endfor
                </tr>
            @endfor
            </table>
        </div>
    @endforeach
</body>
</html>

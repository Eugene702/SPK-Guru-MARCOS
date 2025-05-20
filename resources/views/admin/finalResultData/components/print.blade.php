<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Perangkingan Alternatif Terbaik Tahun 2025</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            width: 100%;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            position: relative;
        }

        .logo {
            width: 60px;
            height: 60px;
            margin-bottom: 15px;
            border: 2px solid #194080;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .logo i {
            font-size: 28px;
            color: #194080;
        }

        .title {
            color: #194080;
            font-weight: 700;
            font-size: 18px;
            margin: 0;
            line-height: 1.4;
            text-transform: uppercase;
        }

        .subtitle {
            color: #194080;
            font-weight: 700;
            font-size: 16px;
            margin-top: 5px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #194080;
            color: white;
            font-weight: 500;
            text-align: center;
            padding: 12px 10px;
        }

        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }

        .rank {
            font-weight: 700;
        }

        .trophy {
            color: gold;
            margin-right: 5px;
            font-size: 18px;
        }

        .best {
            background-color: #3e7a43;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .empty-status {
            color: #666;
        }

        .footer {
            padding: 15px;
            text-align: center;
            font-size: 12px;
            font-style: italic;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }

        @media (max-width: 480px) {
            .container {
                width: 100%;
            }

            table {
                font-size: 14px;
            }

            th,
            td {
                padding: 8px 5px;
            }

            .title,
            .subtitle {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="{{ public_path('/logo.png') }}" alt="Logo" style="width: 100%; height: 100%; border-radius: 50%;">
            </div>
            <h1 class="title">Hasil Perangkingan</h1>
            <h2 class="subtitle">Alternatif Terbaik Tahun {{ now()->year }}</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Nama Alternatif</th>
                    <th>Nilai Akhir</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ranking as $row)
                    <tr>
                        <td class="rank">{{ $loop->iteration }}</td>
                        <td><i class="fas fa-trophy trophy"></i>{{ $row['nama'] }}</td>
                        <td>{{ number_format($row['fk'] * 100, 2) }}%</td>
                        @if ($loop->iteration == 1)
                            <td><span class="best">Terbaik</span></td>
                        @else
                            <td class="empty-status">-</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            "Prestasi bukanlah kebetulan, melainkan hasil dari kerja keras, ketekunan, dan dedikasi yang konsisten."
        </div>
    </div>
</body>

</html>

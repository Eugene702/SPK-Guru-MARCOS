<!DOCTYPE html>
<html>
<head>
    <title>Tabel Ranking</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .data-table thead tr {
            background-color: #3498db;
            color: white;
            text-align: left;
        }
        
        .data-table th {
            padding: 15px;
            border-bottom: 2px solid #2980b9;
        }
        
        .data-table td {
            padding: 12px 15px;
        }
        
        .data-table tbody tr {
            border-bottom: 1px solid #eaeaea;
        }
        
        .data-table tbody tr:nth-of-type(even) {
            background-color: #f9f9f9;
        }
        
        .data-table tbody tr:last-of-type {
            border-bottom: 2px solid #3498db;
        }
        
        .rank-1 {
            font-weight: bold;
            color: gold;
        }
        
        .rank-2 {
            font-weight: bold;
            color: silver;
        }
        
        .rank-3 {
            font-weight: bold;
            color: #cd7f32; /* Bronze */
        }
        
        .normal-rank {
            font-weight: bold;
            color: #2c3e50;
        }
        
        .print-date {
            text-align: right;
            margin-top: 20px;
            font-size: 12px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <h2>Data Ranking</h2>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Fk</th>
                <th>Rangking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ranking as $row)
                <tr>
                    <td>{{ $row['nama'] }}</td>
                    <td>{{ $row['fk'] }}</td>
                    <td class="{{ $loop->iteration < 3 ? 'rank-'.($loop->iteration) : 'normal-rank' }}">{{ $loop->iteration }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="print-date">
        Dicetak pada: {{ date('d/m/Y') }}
    </div>
</body>
</html>
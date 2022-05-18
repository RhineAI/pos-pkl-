<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pendapatan</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0-beta1/js/bootstrap.min.js">
</head>
<body>
    <h3 class="text-center">Laporan Pendapatan</h3>
    <h4 class="text-center">
        Tanggal {{ tanggal_indonesia($awal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }}
    </h4>

    <div class="table table-stripped">
        <thead>
            <tr>
                <th width="5%">No</th>   
                <th>Tanggal</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $item)
                <tr>
                    @foreach ($row as $col)
                        {{ $col }}
                        
                    @endforeach    
                </tr>
            @endforeach
        </tbody>
    </div>

</body>
</html>
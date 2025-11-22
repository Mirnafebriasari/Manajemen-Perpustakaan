@extends('layouts.app')

@section('title', 'Analytics & Reporting')

@section('content')
<h1>Analytics & Reporting</h1>

<canvas id="loansChart" width="400" height="200"></canvas>
<canvas id="booksChart" width="400" height="200"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const loansData = @json($loansPerMonth);
    const booksData = @json($booksPerCategory);

    // Data for loans chart
    const loansLabels = loansData.map(item => item.month);
    const loansCounts = loansData.map(item => item.total);

    const ctxLoans = document.getElementById('loansChart').getContext('2d');
    const loansChart = new Chart(ctxLoans, {
        type: 'line',
        data: {
            labels: loansLabels,
            datasets: [{
                label: 'Jumlah Peminjaman per Bulan',
                data: loansCounts,
                borderColor: 'rgb(75, 192, 192)',
                fill: false,
                tension: 0.1
            }]
        }
    });

    // Data for books chart
    const booksLabels = booksData.map(item => item.category);
    const booksCounts = booksData.map(item => item.total);

    const ctxBooks = document.getElementById('booksChart').getContext('2d');
    const booksChart = new Chart(ctxBooks, {
        type: 'bar',
        data: {
            labels: booksLabels,
            datasets: [{
                label: 'Jumlah Buku per Kategori',
                data: booksCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
            }]
        }
    });
</script>

{{-- Tambahkan juga tabel jika perlu --}}
<h2>Data Peminjaman per Bulan</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr><th>Bulan</th><th>Jumlah Peminjaman</th></tr>
    </thead>
    <tbody>
        @foreach($loansPerMonth as $item)
            <tr><td>{{ $item->month }}</td><td>{{ $item->total }}</td></tr>
        @endforeach
    </tbody>
</table>

<h2>Data Buku per Kategori</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr><th>Kategori</th><th>Jumlah Buku</th></tr>
    </thead>
    <tbody>
        @foreach($booksPerCategory as $item)
            <tr><td>{{ $item->category }}</td><td>{{ $item->total }}</td></tr>
        @endforeach
    </tbody>
</table>

@endsection

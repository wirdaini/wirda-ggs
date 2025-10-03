<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pegawai/Mahasiswa</title>
    <!-- Gak ada CSS, cuma teks sederhana -->
</head>
<body>
    <h1>Data Profil</h1>

    <p><strong>Nama:</strong> {{ $name }}</p>

    <p><strong>Tanggal Lahir:</strong> {{ $tgl_lahir }}</p>

    <p><strong>Umur:</strong> {{ $my_age }} tahun</p>

    <h2>Hobbies:</h2>
    <ul>
        @foreach ($hobbies as $hobby)
            <li>{{ $hobby }}</li>
        @endforeach
    </ul>

    <p><strong>Tanggal Sekarang:</strong> {{ $tgl_skrg }}</p>

    <p><strong>Tanggal Harus Wisuda:</strong> {{ $tgl_harus_wisuda }}</p>

    <p><strong>Time to Study Left:</strong> {{ $time_to_study_left }} hari</p>

    <p><strong>Semester Saat Ini:</strong> {{ $current_semester }}</p>  <!-- Ini akan tampil sebagai message dari if-else di controller -->

    <hr>  <!-- Garis pemisah sederhana -->
    <p>Halaman ini dibuat sederhana, hanya teks aja. Data dari controller PegawaiController.</p>
</body>
</html>

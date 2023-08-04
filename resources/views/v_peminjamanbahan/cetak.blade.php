<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form {{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        * {
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center my-4 mx-5" style="border-style: none none double none">
        <div class="d-flex align-items-center m-3">
            <img src="{{ asset('img/logo.png') }}" alt="" width="120">
        </div>
        <div class="text-center m-3">
            <p>
                KEMENTRIAN PENDIDIKAN, KEBUDAYANAAN, RISET, DAN TEKNOLOGI <br>
                <b>POLITEKNIK NEGERI SUBANG</b> <br>
                Jl. Brigjen Katamso No. 37 (Belakang RSUD), Dangdeur, Subang, Jawa Barat 41211 <br>
                Telp. (0260) 417648, Fax. (0260) 417628 <br>
                Homepage: http://www.polsub.ac.id -- e-email : info@polsub.ac.id
            </p>
        </div>
    </div>
    <p class="text-center mb-5">
        <b>
            FORM PEMINJAMAN ALAT DAN BAHAN PRAKTIKUM/FASILITAS <br>
            JURUSAN MANAJEMEN INFORMATIKA <br>
            POLITEKNIK NEGERI SUBANG <br>
            TAHUN {{ date('Y') }}
        </b>
    </p>
    <div class="mx-5">
        <table class="table table-bordered">
            <tr class="text-center">
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Keperluan</th>
                <th class="text-wrap">Tanggal Peminjam</th>
                <th class="text-wrap">Tanggal Pengembalian</th>
                <th>Kondisi</th>
            </tr>
            <tr>
                <td>1</td>
                <td>{{ $pinjam->user->nama }}</td>
                <td>{{ $pinjam->bahanjurusan->nama }}</td>
                <td>{{ $pinjam->jumlah }}</td>
                <td class="text-wrap">{{ $pinjam->deskripsi }}</td>
                <td>{{ $pinjam->tgl_pinjam }}</td>
                <td>{{ $pinjam->tgl_kembali }}</td>
                <td class="text-wrap">{{ $pinjam->kondisi }}</td>
            </tr>
        </table>
    </div>

    <p class="text-center my-5 mb-0">Mengetahui,</p>
    <div class="d-flex justify-content-between my-0 mx-5">
        <div class="ms-5">
            <p class="mb-5 pb-3">
                &nbsp;<br>
                Peminjam,
            </p>
            <p>
                {{ $pinjam->user->nama }} <br>
                NIP/NIK/NIM. {{ $pinjam->user->nomor_induk }}
            </p>
        </div>
        <div class="me-5">
            <p class="">
                Subang, {{ Illuminate\Support\Carbon::now()->isoFormat('D MMMM Y') }} <br>
                Kepala Laboratorium
            </p>
            @if ($pinjam->status == 'disetujui' || $pinjam->status == 'selesai')
                <div class="text-center">
                    <i class="bi bi-check fs-1"></i>
                </div>
            @endif
            <p>
                {{ $pinjam->bahanjurusan->laboratorium->user->nama }} <br>
                NIP/NIK. {{ $pinjam->bahanjurusan->laboratorium->user->nomor_induk }}
            </p>
            <p>

            </p>
        </div>
    </div>
    <div class=" text-center">
        <p class="">
            Ketua Jurusan,
        </p>
        @if ($pinjam->status == 'disetujui' || $pinjam->status == 'selesai')
            <div class="text-center">
                <i class="bi bi-check fs-1"></i>
            </div>
        @endif
        <p>
            {{ $kajur->user->nama }} <br>
            NIP/NIK. {{ $kajur->user->nomor_induk }}
        </p>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>
</body>

</html>

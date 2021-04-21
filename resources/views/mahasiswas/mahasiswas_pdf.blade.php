<!DOCTYPE html>
<html lang="">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <title>Cetak KRS</title>
</head>

<body>
    <div class="text-center card-header">
        <h3>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h3>
        <h4>Kartu Hasil Studi</h4>
    </div>

    @if($mahasiswa)
    <p><strong>Nim&nbsp;: </strong>{{ $mahasiswa->mahasiswa->Nim }}</p>
    <p><strong>Nama&nbsp;: </strong>{{ $mahasiswa->mahasiswa->Nama }}</p>
    <p><strong>Kelas&nbsp;: </strong>{{ $mahasiswa->mahasiswa->Kelas->nama_kelas }}</p>
    @else
    <h2>Belum ada data!</h2>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Nilai</th>
        </tr>
        @if($nilai)
        @foreach($nilai as $Nilai)
        <tr>
            <td>{{ $Nilai->matakuliah->nama_matkul }}</td>
            <td>{{ $Nilai->matakuliah->sks }}</td>
            <td>{{ $Nilai->matakuliah->semester }}</td>
            <td>{{ $Nilai->nilai }}</td>
        </tr>
        @endforeach
        @endif
    </table>
</body>

</html>
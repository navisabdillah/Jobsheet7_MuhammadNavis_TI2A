<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\Mahasiswa_Matakuliah;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('search')){
            $mahasiswas = Mahasiswa::where('Nama', 'like', "%".$request->search."%")->paginate(5);
            $mahasiswas = Mahasiswa::where('Nama', 'like', "%".$request->search."%")
                ->orWhere('Nim', $request->search)
                ->paginate(3);
        } else{
            $mahasiswas = Mahasiswa::with('kelas')->paginate(3);
            $mahasiswas = Mahasiswa::paginate(3);
        }      
        $paginate = Mahasiswa::orderBy('Nim', 'asc')->paginate(3);
        return view('mahasiswas.index', ['mahasiswas' => $mahasiswas, 'paginate' => $paginate]);
        return view('mahasiswas.index', compact('mahasiswas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswas.create',['kelas' => $kelas]);
        return view('mahasiswas.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'Tanggal_lahir' => 'required',
        ]);

        $mahasiswa = new Mahasiswa;
        $mahasiswa->Nim = $request->get('Nim');
        $mahasiswa->Nama = $request->get('Nama');
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->Jurusan = $request->get('Jurusan');
        $mahasiswa->Email = $request->get('Email');
        $mahasiswa->Alamat = $request->get('Alamat');
        $mahasiswa->Tanggal_lahir = $request->get('Tanggal_lahir');
        $mahasiswa->save();

       // $kelas = new Kelas;
       // $kelas->id = $request->get('Kelas');

       // $mahasiswas->kelas()->assocaite($kelas);
       // $mahasiswas->save();

       if($request->file('image')){
        $image_name = $request->file('image')->store('images', 'public');
    } else {
        $image_name = 'images/navis.png';
        $image_name = 'images/dandi.png';
        $image_name = 'images/muhammad.png';
    }

    // Jika data berhasil ditambahkan, akan kembali ke halaman utama
    return redirect()->route('mahasiswas.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        // Menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        return view('mahasiswas.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        // Menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::find($Nim);
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('Mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        // Melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'Tanggal_lahir' => 'required',
        ]);

        $mahasiswa = new Mahasiswa;
        $mahasiswa->Nim = $request->get('Nim');
        $mahasiswa->Nama = $request->get('Nama');
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->Jurusan = $request->get('Jurusan');
        $mahasiswa->Email = $request->get('Email');
        $mahasiswa->Alamat = $request->get('Alamat');
        $mahasiswa->Tanggal_lahir = $request->get('Tanggal_lahir');
        $mahasiswa->save();
        //fungsi eloquent untuk mengupdate data inputan kita
        //Mahasiswa::find($Nim)->update($request->all());

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
        ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        // Fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswas.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');
    }
    public function nilai($Nim){
        $mahasiswa = Mahasiswa_Matakuliah::with('mahasiswa')
            ->where('mahasiswa_id', $Nim)
            ->first();
        $nilai = Mahasiswa_Matakuliah::with('matakuliah')
            ->where('mahasiswa_id', $Nim)
            ->get();
        return view('mahasiswas.nilai', compact('mahasiswa', 'nilai'));            
    }
    public function cetak_pdf($Nim){
        $mahasiswa = Mahasiswa_MataKuliah::with('mahasiswa')
            ->where('mahasiswa_id', $Nim)
            ->first();
        $nilai = Mahasiswa_MataKuliah::with('matakuliah')
            ->where('mahasiswa_id', $Nim)
            ->get();
        $pdf = PDF::loadview('mahasiswas.mahasiswas_pdf', compact('mahasiswa', 'nilai'));
        return $pdf->stream();
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = mahasiswa::orderBy('nim', 'desc')->paginate(2);
        return view('mahasiswa.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::flash('nim', $request->nim);
        Session::flash('nama', $request->nama);
        Session::flash('jurusan', $request->jurusan);
      

        $request->validate([
            'nim'=> 'required|numeric|unique:mahasiswa,nim',
            'nama'=> 'required',
            'jurusan'=> 'required',
        ],[
            'nim.required'=> 'nim wajib diisi',
            'nim.numeric'=> 'nim wajib dalam angka',
            'nim.unique'=> 'nim sudah ada dalam data',
            'nama.required'=> 'nama wajib diisi',
            'jurusan.required'=> 'jurusan wajib diisi',
        ]);
        $data = [
            'nim'=> $request->nim,
            'nama'=> $request->nama,
            'jurusan'=> $request->jurusan,
        ];
        mahasiswa::create($data);
        return redirect()->to('mahasiswa')->with ('success', 'berhasil memasukan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = mahasiswa::where('nim', $id)->first();
        return view('mahasiswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'=> 'required',
            'jurusan'=> 'required',
        ],[
            'nama.required'=> 'nama wajib diisi',
            'jurusan.required'=> 'jurusan wajib diisi',
        ]);
        $data = [
            'nama'=> $request->nama,
            'jurusan'=> $request->jurusan,
        ];
        mahasiswa::where('nim', $id)->update($data);
        return redirect()->to('mahasiswa')->with ('success', 'update berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        mahasiswa::where('nim', $id)->delete();
        return redirect()->to('mahasiswa')->with('success','data telah di delete');
    }
}

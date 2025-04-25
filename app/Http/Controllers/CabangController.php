<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;
use Validator;
use Maatwebsite\Excel\Facades\Excel;

class CabangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $cabangs = Cabang::where(function ($query) use ($search) {
            $query->orWhere('nama_cabang', 'like', '%' . $search . '%')
                ->orWhere('alamat_cabang', 'like', '%' . $search . '%')
                ->orWhere('logo', 'like', '%' . $search . '%')
                ->orWhere('kota_cabang', 'like', '%' . $search . '%')
                ->orWhere('no_kontak', 'like', '%' . $search . '%')
                ->orWhere('deskripsi', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%')
                ;
        })->orderBy('id', 'desc')->paginate(10);

        return view('cabangs.index', compact('cabangs', 'search'),['namaTabel' => 'Cabang']);
    }

    public function create()
    {
        return view('cabangs.create', ['namaTabel' => 'Cabang']);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['nama_cabang' => 'required',
 'alamat_cabang' => 'required',
 'logo' => 'required',
 'kota_cabang' => 'required',
 'no_kontak' => 'required',
 'deskripsi' => 'required',
 'status' => 'required']
        );
        
        if ($validator->fails()) 
            return redirect()->back()->withInput()->withErrors($validator);
        
        $data['nama_cabang'] = $request->nama_cabang;
$data['alamat_cabang'] = $request->alamat_cabang;
$data['logo'] = $request->logo;
$data['kota_cabang'] = $request->kota_cabang;
$data['no_kontak'] = $request->no_kontak;
$data['deskripsi'] = $request->deskripsi;
$data['status'] = $request->status;

        
        Cabang::create($data);

        return redirect()->route('cabangs.index');
    }

    public function show($id)
    {
        $Cabang = Cabang::find($id);
        return view('cabangs.show', compact('Cabang'));
    }

    public function edit($id)
    {
        $Cabang = Cabang::find($id);
        return view('cabangs.edit', compact('Cabang'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ['nama_cabang' => 'required',
 'alamat_cabang' => 'required',
 'logo' => 'required',
 'kota_cabang' => 'required',
 'no_kontak' => 'required',
 'deskripsi' => 'required',
 'status' => 'required']);
        
        if ($validator->fails()) 
            return redirect()->back()->withInput()->withErrors($validator);
        

        $data['nama_cabang'] = $request->nama_cabang;
$data['alamat_cabang'] = $request->alamat_cabang;
$data['logo'] = $request->logo;
$data['kota_cabang'] = $request->kota_cabang;
$data['no_kontak'] = $request->no_kontak;
$data['deskripsi'] = $request->deskripsi;
$data['status'] = $request->status;


        Cabang::whereId($id)->update($data);

        return redirect()->route('cabangs.index');
    }

    public function destroy($id)
    {
        
        try {
                    $data = Cabang::find($id);
                if($data) {
                    # code...
                    $data->delete();
                }
                return redirect()->route('cabangs.index')->with('success', 'Data berhasil dihapus.');
            } catch (\Illuminate\Database\QueryException $e) {
                // Cek apakah error adalah error foreign key constraint
                if ($e->errorInfo[1] == 1451) {
                    // Redirect dengan pesan error
                    return redirect()->back()->with('error', 'Proses delete gagal. Tidak diizinkan karena ada data terkait.');
                }
        
                // Handle error lain
                return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
            }
    }

    public function export()
    {
        return Excel::download(new CabangExport, 'cabangs.xlsx');
    }
}

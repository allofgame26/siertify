<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\identitasmodel;
use Illuminate\Support\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class datapenggunaSuperadminController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Data Pengguna',
            'list' => ['Selamat Datang','Data Pengguna']
        ];

        $page = (object)[
            'title' => 'Data Pengguna'
        ];

        $activeMenu = 'datapengguna';

        return view('superadmin.data.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $identitas= identitasmodel::select('id_identitas','nama_lengkap','NIP','jenis_kelamin','alamat','email','no_telp','foto_profil');

             //Filter data user berdasarkan level_id
             if ($request->id_jenis_pengguna) {
                $identitas->where('id_jenis_pengguna', $request->id_jenis_pengguna);
            }

        // Return data untuk DataTables
        return DataTables::of($identitas)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->editColumn('foto_profil', function ($identitas) {
                // Cek apakah foto_profil ada atau gunakan gambar default jika kosong
                $foto_profil = $identitas->foto_profil ? asset('img/' . $identitas->foto_profil) : asset('img/profil-pic.png');
            
                return '<img src="' . $foto_profil . '" style="width: 70px; height: 70px;" />';
            })
            ->addColumn('aksi', function ($identitas) {
                $btn = '<button onclick="modalAction(\'' . url('/datapengguna/' . $identitas->id_identitas . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/datapengguna/' . $identitas->id_identitas . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/datapengguna/' . $identitas->id_identitas . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
                return $btn;
            })
            

            ->rawColumns(['foto_profil','aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    public function create(){
        return view('superadmin.data.create');
    }

    public function store(Request $request){
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_lengkap' => 'required|string|min:10|max:100',
                'NIP' => 'required|string|min:10|max:20',
                'tempat_lahir' => 'required|string|min:5|max:10',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|string|in:laki,perempuan',
                'alamat' => 'required|string|min:10|max:100',
                'no_telp' => 'required|string|min:10|max:15',
                'email' => 'required|string|min:10|max:50',
                'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            $datapengguna = identitasmodel::create([
                'nama_lengkap' => $request->nama_lengkap,
                'NIP' => $request->NIP,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
                'foto_profil' => 'profil-pic.png',
            ]);

    
            // Jika fot_profil ada, proses penyimpanan gambar
            if ($request->hasFile('foto_profil')) {
                // Gunakan ID user yang baru dibuat untuk nama file
                $fileName = 'profile_' . $datapengguna->id_identitas . '.' . $request->foto_profil->getClientOriginalExtension();
    
                // Simpan gambar di direktori 'gambar'
                $request->foto_profil->move(public_path('gambar'), $fileName);
    
                // Update datapengguna dengan nama file foto_profil baru
                $datapengguna->foto_profil = $fileName;
                $datapengguna->save(); // Simpan perubahan ke database
            }

            if($datapengguna){
                return response()->json([
                    'status'    => true,
                    'message'   => 'Data user berhasil disimpan'
                ], 200);
            }


            return response()->json([
                'status' => true,
                'message' => 'Data Jenis berhasil disimpan'
            ]);
        }
        return redirect('/datapengguna');
    }

    public function edit(string $id){
        $datapengguna = identitasmodel::find($id);
        return view('superadmin.data.edit', ['datapengguna' => $datapengguna]);
    }

    public function update(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_lengkap' => 'required|string|min:10|max:100',
                'NIP' => 'required|string|min:10|max:20|unique:m_identitas,NIP,'.$id.',id_identitas',
                'tempat_lahir' => 'required|string|min:5|max:10',
                'tanggal_lahir' => 'required|date|before:today',
                'jenis_kelamin' => 'required|string|in:laki,perempuan',
                'alamat' => 'required|string|min:10|max:100',
                'no_telp' => 'required|string|min:10|max:15',
                'email' => 'required|string|min:10|max:50',
                'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'

            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = identitasmodel::find($id);
            if ($check) {

                if ($request->hasFile('foto_profil')) {

                    $fileName = 'profile_' . $check->id_identitas . '.' . $request->foto_profil->getClientOriginalExtension();
    
                    // Check if an existing profile picture exists and delete it
                    $oldFile = public_path('img/'. $fileName);
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }
    
                    $request->foto_profil->move(public_path('img'), $fileName);

                } else {
                    $fileName = 'profil-pic.png'; // default foto_profil
                }

                identitasmodel::find($id)->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'NIP' => $request->NIP,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'alamat' => $request->alamat,
                    'no_telp' => $request->no_telp,
                    'email' => $request->email,
                    'foto_profil' => $fileName,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);

            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/datapengguna');
    }

    public function delete(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $datapengguna = identitasmodel::find($id);
            if ($datapengguna) {
                $datapengguna->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/datapengguna');
    }

    public function show(string $id)
    {
        $datapengguna = identitasmodel::find($id);
        return view('superadmin.data.show', ['datapen$datapengguna' => $datapengguna]);
    }

    public function confirm(string $id){
        $datapengguna = identitasmodel::find($id);
        return view('superadmin.data.delete', ['datapengguna' => $datapengguna]);
    }
    
    public function import(){
        return view('superadmin.data.import');
    }

    public function import_proses(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
        // validasi file harus xls atau xlsx, max 1MB
                'file_datapengguna' => ['required', 'mimes:xlsx', 'max:1024'],
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_datapengguna'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'nama_lengkap' => $value['A'],
                            'NIP' => $value['B'],
                            'tempat_lahir' => $value['C'],
                            'tanggal_lahir' => $value['D'],
                            'jenis_kelamin' => $value['E'],
                            'alamat' => $value['F'],
                            'no_telp' => $value['G'],
                            'email' => $value['H'],
                        ];
                    }
                }
                if (count($insert) > 0) {
            // insert data ke database, jika data sudah ada, maka diabaikan
                    identitasmodel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport',
                ]);
            }
        }
        return redirect('/datapengguna');
    }
    public function export_excel()
    {
        //ambil data yang akan di export
        $datapengguna = identitasmodel::select('id_identitas', 'nama_lengkap', 'NIP', 'tempat_lahir','tanggal_lahir','jenis_kelamin', 'alamat','no_telp','email')
            ->orderBy('id_identitas')
            ->get();

        //load library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Lengkap');
        $sheet->setCellValue('C1', 'NIP');
        $sheet->setCellValue('D1', 'Tempat Lahir');
        $sheet->setCellValue('E1', 'Tanggal Lahir');
        $sheet->setCellValue('F1', 'Jenis Kelamin');
        $sheet->setCellValue('G1', 'Alamat');
        $sheet->setCellValue('H1', 'Nomor Telefon');
        $sheet->setCellValue('I1', 'E - Mail');

        $sheet->getStyle('A1:I1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($datapengguna as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_lengkap);
            $sheet->setCellValue('C' . $baris, $value->NIP);
            $sheet->setCellValue('D' . $baris, $value->tempat_lahir);
            $sheet->setCellValue('E' . $baris, $value->tanggal_lahir);
            $sheet->setCellValue('F' . $baris, $value->jenis_kelamin);
            $sheet->setCellValue('G' . $baris, $value->alamat);
            $sheet->setCellValue('H' . $baris, $value->no_telp);
            $sheet->setCellValue('I' . $baris, $value->email);
            $baris++;
            $no++;

        }

        foreach (range('A', 'I') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Identitas Pengguna');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Identitas Pengguna ' . date('Y-m-d H:i:s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, dMY H:i:s') . 'GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;

    }

    public function export_pdf(){
         //ambil data yang akan di export
         $datapengguna = identitasmodel::select('id_identitas', 'nama_lengkap', 'NIP', 'tempat_lahir','tanggal_lahir','jenis_kelamin', 'alamat','no_telp','email')
            ->orderBy('id_identitas')
            ->get();

         //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('superadmin.data.export', ['datapengguna'=>$datapengguna]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data Pengguna '.date('Y-m-d H:i:s').'.pdf');
    }
}

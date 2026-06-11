<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa')->with(['kelas', 'jurusan']);
        
        // Filter
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('name', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->has('kelas_id') && $request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }
        
        if ($request->has('jurusan_id') && $request->jurusan_id) {
            $query->where('jurusan_id', $request->jurusan_id);
        }
        
        $siswa = $query->orderBy('created_at', 'desc')->paginate(15);
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        
        return view('admin.siswa.index', compact('siswa', 'kelas', 'jurusan'));
    }
    
    public function create()
    {
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        return view('admin.siswa.create', compact('kelas', 'jurusan'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:users',
            'name' => 'required',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required',
            'jurusan_id' => 'required',
            'tahun_ajaran' => 'required',
            'no_telepon' => 'nullable',
            'alamat' => 'nullable'
        ]);
        
        User::create([
            'nis' => $request->nis,
            'name' => $request->name,
            'username' => $request->nis,
            'password' => Hash::make('siswa123'),
            'role' => 'siswa',
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id' => $request->kelas_id,
            'jurusan_id' => $request->jurusan_id,
            'tahun_ajaran' => $request->tahun_ajaran,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'status_aktif' => true
        ]);
        
        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $siswa = User::findOrFail($id);
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas', 'jurusan'));
    }
    
    public function update(Request $request, $id)
    {
        $siswa = User::findOrFail($id);
        
        $request->validate([
            'nis' => 'required|unique:users,nis,' . $id,
            'name' => 'required',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required',
            'jurusan_id' => 'required',
            'tahun_ajaran' => 'required'
        ]);
        
        $siswa->update([
            'nis' => $request->nis,
            'name' => $request->name,
            'username' => $request->nis,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id' => $request->kelas_id,
            'jurusan_id' => $request->jurusan_id,
            'tahun_ajaran' => $request->tahun_ajaran,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
            'status_aktif' => $request->status_aktif ?? true
        ]);
        
        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();
        
        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;
use App\Exports\TableExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::all();
        return view('admin.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string',
            'kemasan' => 'required|string|max:35',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return redirect()
            ->route('obat.index')
            ->with('message', 'Data Obat Berhasil dibuat')
            ->with('type', 'success');
    }

    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id);

        return view('admin.obat.edit')->with([
            'obat' => $obat
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_obat' => 'required|string',
            'kemasan' => 'nullable|string|max:35',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $obat = Obat::findOrFail($id);

        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        return redirect()
            ->route('obat.index')
            ->with('message', 'Data Obat berhasil di edit')
            ->with('type', 'success');
    }

    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()
            ->route('obat.index')
            ->with('message', 'Data Obat berhasil di Hapus')
            ->with('type', 'success');
    }

    public function export()
    {
        $obats = Obat::all();

        return Excel::download(
            new TableExport(
                'admin.obat.export',
                compact('obats')
            ),
            'Data_Obat.xlsx'
        );
    }

    public function exportPdf()
    {
        $obats = Obat::all();

        return Pdf::loadView(
            'admin.obat.export',
            compact('obats')
        )
            ->setPaper('a4', 'portrait')
            ->download('Data_Obat.pdf');
    }
}

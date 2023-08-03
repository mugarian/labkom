<?php

namespace App\Http\Controllers;

use Algorithm\C45;
use App\Models\User;
use App\Models\Dosen;
use Ramsey\Uuid\Uuid;
use App\Models\Prediksi;
use App\Models\Algoritma;
use App\Models\DataMentah;
use Algorithm\C45\DataInput;
use App\Models\DataTraining;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PrediksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $dosen = Dosen::where('user_Id', $user->id)->first();
        $prediksis = DataTraining::where('isPrediksi', 1)->latest()->get();

        return view('v_prediksi.index', [
            'title' => 'Data prediksi',
            'prediksis' => $prediksis,
            'dosen' => $dosen
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('v_prediksi.create', [
            'title' => 'Tambah Data Prediksi',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'kategori' => 'required',
            'satuan' => 'required',
            'tahun_pengadaan' => 'required',
            'jumlah_pengadaan' => 'required',
            'isi_barang_persatuan' => 'required',
            'jumlah_matkul' => 'required',
            'jumlah_siswa_perkelas' => 'required',
            'jumlah_kelas' => 'required',
            'jenis_pemegang_barang' => 'required',
            'jumlah_pemegang_barang' => 'required',
            'harga_barang_beli' => 'required',
            'stok_barang' => 'required',
            'jenis_bahan' => 'required',
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['isPrediksi'] = 1;
        $validatedData['jumlah_barang_perpcs'] = $validatedData['jumlah_pengadaan'] * $validatedData['isi_barang_persatuan'];
        if ($validatedData['jenis_pemegang_barang'] == 'orang') {
            $validatedData['jumlah_kebutuhan_total'] = $validatedData['jumlah_matkul'] * $validatedData['jumlah_siswa_perkelas'] * $validatedData['jumlah_kelas'] * $validatedData['jumlah_pemegang_barang'];
        } else {
            $validatedData['jumlah_kebutuhan_total'] = $validatedData['jumlah_pemegang_barang'];
        }

        if ($validatedData['jumlah_barang_perpcs'] < $validatedData['jumlah_kebutuhan_total']) {
            $jenis_pengadaan = 'kurang dari kuota';
        } elseif ($validatedData['jumlah_barang_perpcs'] = $validatedData['jumlah_kebutuhan_total']) {
            $jenis_pengadaan = 'sesuai kuota';
        } else {
            $jenis_pengadaan = 'melebihi kuota';
        }

        if ($validatedData['stok_barang'] < $validatedData['jumlah_kebutuhan_total']) {
            $jenis_stok = 'stok kurang';
        } elseif ($validatedData['stok_barang'] = $validatedData['jumlah_kebutuhan_total']) {
            $jenis_stok = 'stok pas';
        } else {
            $jenis_stok = 'stok lebih';
        }

        $dm = DataMentah::create($validatedData);
        $data_training = [
            'id' => (string) Uuid::uuid4(),
            'datamentah_id' => $dm->id,
            'isPrediksi' => 1,
            'jenis_pengadaan' => $jenis_pengadaan,
            'jenis_stok' => $jenis_stok,
            'tahun_pengadaan' => $validatedData['tahun_pengadaan'],
        ];

        DataTraining::create($data_training);

        $this->dataKuartil();
        $this->labeling();

        return redirect('/prediksi')->with('success', 'Tambah Data prediksi Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prediksi  $prediksi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prediksi = DataTraining::find($id);
        return view('v_prediksi.show', [
            'title' => 'Data Prediksi ' . $prediksi->datamentah->nama,
            'prediksi' => $prediksi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prediksi  $prediksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Prediksi $prediksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prediksi  $prediksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prediksi $prediksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prediksi  $prediksi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $training = DataTraining::find($id);
        try {
            DataTraining::destroy($id);
            DataMentah::destroy($training->datamentah_id);

            return redirect('/prediksi')->with('success', 'Data prediksi telah dihapus');
        } catch (\Throwable $th) {
            return redirect('/prediksi')->with('fail', 'Gagal Menghapus Data Karena Data Terhubung dengan Data Lain');
        }
    }

    public function prediksi($pengajuan, $harga, $jenis_bahan)
    {
        $c45 = new C45();
        $input = new DataInput;
        $trainings = Algoritma::all();
        $atts = array();
        $count = 0;
        foreach ($trainings as $training) {
            $atts[$count++] = array(
                "pengajuan" => $training->pengajuan,
                "harga" => $training->harga,
                "label" => $training->label,
                "jenis_bahan" => $training->jenis_bahan,
            );
        }

        // Initialize Data
        $input->setData($atts); // Set data from array
        $input->setAttributes(array('harga', 'pengajuan', 'jenis_bahan', 'label')); // Set attributes of data

        // Initialize C4.5
        $c45->c45 = $input; // Set input data
        $c45->setTargetAttribute('label'); // Set target attribute
        $initialize = $c45->initialize(); // initialize

        // Build Output
        $buildTree = $initialize->buildTree(); // Build tree

        $new_data = array(
            'pengajuan' => $pengajuan,
            'harga' => $harga,
            'jenis_bahan' => $jenis_bahan
        );

        $label = $c45->initialize()->buildTree()->classify($new_data);
        return $label;
    }

    public function import(Request $request)
    {
        $validatedData = $request->validate([
            'import' => 'required|file|mimes:xls,xlsx|max:8000'
        ]);

        $excelFile = $request->file('import');

        try {
            $spreadsheet = IOFactory::load($excelFile->getRealPath());
            $sheet        = $spreadsheet->getSheet(0);
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range(2, $row_limit);
            $column_range = range('A', $column_limit);
            $startcount = 2;

            foreach ($row_range as $row) {
                $data_mentah = [
                    'id' => (string) Uuid::uuid4(),
                    'user_id' => auth()->user()->id,
                    'isPrediksi' => 1,
                    'nama' => $sheet->getCell('A' . $row)->getValue(),
                    'kategori' => $sheet->getCell('B' . $row)->getValue(),
                    'satuan' => $sheet->getCell('C' . $row)->getValue(),
                    'tahun_pengadaan' => $sheet->getCell('D' . $row)->getValue(),
                    'jumlah_pengadaan' => $sheet->getCell('E' . $row)->getValue(),
                    'isi_barang_persatuan' => $sheet->getCell('F' . $row)->getValue(),
                    'jumlah_barang_perpcs' => $sheet->getCell('G' . $row)->getCalculatedValue(),
                    'jumlah_matkul' => $sheet->getCell('H' . $row)->getValue(),
                    'jumlah_siswa_perkelas' => $sheet->getCell('I' . $row)->getValue(),
                    'jumlah_kelas' => $sheet->getCell('J' . $row)->getValue(),
                    'jenis_pemegang_barang' => $sheet->getCell('K' . $row)->getValue(),
                    'jumlah_pemegang_barang' => $sheet->getCell('L' . $row)->getValue(),
                    'jumlah_kebutuhan_total' => $sheet->getCell('M' . $row)->getCalculatedValue(),
                    'harga_barang_beli' => $sheet->getCell('N' . $row)->getValue(),
                    'stok_barang' => $sheet->getCell('O' . $row)->getValue(),
                    'jenis_bahan' => $sheet->getCell('P' . $row)->getValue(),
                    'label' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $dm = DataMentah::create($data_mentah);

                $data_training = [
                    'id' => (string) Uuid::uuid4(),
                    'datamentah_id' => $dm->id,
                    'isPrediksi' => 1,
                    'jenis_pengadaan' => $sheet->getCell('Q' . $row)->getCalculatedValue(),
                    'jenis_stok' => $sheet->getCell('R' . $row)->getCalculatedValue(),
                    'tahun_pengadaan' => $sheet->getCell('D' . $row)->getCalculatedValue(),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                DataTraining::create($data_training);
            }
            $this->dataKuartil();
            $this->labeling();
        } catch (\Exception $e) {
            return redirect('/prediksi')->with('fail', 'Import Data Training Gagal');
        }
        return redirect('/prediksi')->with('success', 'Import Data Training Berhasil');
    }

    public function dataKuartil()
    {
        $hardwarecpus = DataMentah::where('kategori', 'hardware cpu')->where('isPrediksi', 1)->get();
        if (!$hardwarecpus->isEmpty()) {
            $hardwarecpu = array_column($hardwarecpus->toArray(), 'harga_barang_beli');
            $hardwarecpu_q1 = $this->quartile($hardwarecpu, 0.25);
            $hardwarecpu_q2 = $this->quartile($hardwarecpu, 0.5);
            $hardwarecpu_q3 = $this->quartile($hardwarecpu, 0.75);
            $hardwarecpu_q4 = $hardwarecpus->max('harga_barang_beli');
            foreach ($hardwarecpus as $hcpu) {
                $jenis_hargacpu = '';
                if ($hcpu->harga_barang_beli <= $hardwarecpu_q1) {
                    $jenis_hargacpu = 'murah';
                } elseif ($hcpu->harga_barang_beli <= $hardwarecpu_q2) {
                    $jenis_hargacpu = 'sedang';
                } elseif ($hcpu->harga_barang_beli <= $hardwarecpu_q3) {
                    $jenis_hargacpu = 'mahal';
                } elseif ($hcpu->harga_barang_beli <= $hardwarecpu_q4) {
                    $jenis_hargacpu = 'sangat mahal';
                }
                // DataTraining::where('datamentah_id', $hcpu->id)->first()->update(['jenis_harga' => $jenis_hargacpu]);
                $dtcpu = DataTraining::where('datamentah_id', $hcpu->id)->first();
                if ($dtcpu) {
                    $dtcpu->update(['jenis_harga' => $jenis_hargacpu]);
                }
            }
        }

        $komponencpus = DataMentah::where('kategori', 'komponen cpu')->where('isPrediksi', 1)->get();
        if (!$komponencpus->isEmpty()) {
            $komponencpu = array_column($komponencpus->toArray(), 'harga_barang_beli');
            $komponencpu_q1 = $this->quartile($komponencpu, 0.25);
            $komponencpu_q2 = $this->quartile($komponencpu, 0.5);
            $komponencpu_q3 = $this->quartile($komponencpu, 0.75);
            $komponencpu_q4 = $komponencpus->max('harga_barang_beli');
            foreach ($komponencpus as $kcpu) {
                $jenis_hargakcpu = '';
                if ($kcpu->harga_barang_beli <= $komponencpu_q1) {
                    $jenis_hargakcpu = 'murah';
                } elseif ($kcpu->harga_barang_beli <= $komponencpu_q2) {
                    $jenis_hargakcpu = 'sedang';
                } elseif ($kcpu->harga_barang_beli <= $komponencpu_q3) {
                    $jenis_hargakcpu = 'mahal';
                } elseif ($kcpu->harga_barang_beli <= $komponencpu_q4) {
                    $jenis_hargakcpu = 'sangat mahal';
                }
                // DataTraining::where('datamentah_id', $kcpu->id)->first()->update(['jenis_harga' => $jenis_hargakcpu]);
                $dtkcpu = DataTraining::where('datamentah_id', $kcpu->id)->first();
                if ($dtkcpu) {
                    $dtkcpu->update(['jenis_harga' => $jenis_hargakcpu]);
                }
            }
        }

        $komponenelektroniks = DataMentah::where('kategori', 'komponen elektronik')->where('isPrediksi', 1)->get();
        if (!$komponenelektroniks->isEmpty()) {
            $komponenelektronik = array_column($komponenelektroniks->toArray(), 'harga_barang_beli');
            $komponenelektronik_q1 = $this->quartile($komponenelektronik, 0.25);
            $komponenelektronik_q2 = $this->quartile($komponenelektronik, 0.5);
            $komponenelektronik_q3 = $this->quartile($komponenelektronik, 0.75);
            $komponenelektronik_q4 = $komponenelektroniks->max('harga_barang_beli');
            foreach ($komponenelektroniks as $ke) {
                $jenis_hargake = '';
                if ($ke->harga_barang_beli <= $komponenelektronik_q1) {
                    $jenis_hargake = 'murah';
                } elseif ($ke->harga_barang_beli <= $komponenelektronik_q2) {
                    $jenis_hargake = 'sedang';
                } elseif ($ke->harga_barang_beli <= $komponenelektronik_q3) {
                    $jenis_hargake = 'mahal';
                } elseif ($ke->harga_barang_beli <= $komponenelektronik_q4) {
                    $jenis_hargake = 'sangat mahal';
                }
                // DataTraining::where('datamentah_id', $ke->id)->first()->update(['jenis_harga' => $jenis_hargake]);
                $dtke = DataTraining::where('datamentah_id', $ke->id)->first();
                if ($dtke) {
                    $dtke->update(['jenis_harga' => $jenis_hargake]);
                }
            }
        }

        $komponeninternets = DataMentah::where('kategori', 'komponen internet')->where('isPrediksi', 1)->get();
        if (!$komponeninternets->isEmpty()) {
            $komponeninternet = array_column($komponeninternets->toArray(), 'harga_barang_beli');
            $komponeninternet_q1 = $this->quartile($komponeninternet, 0.25);
            $komponeninternet_q2 = $this->quartile($komponeninternet, 0.5);
            $komponeninternet_q3 = $this->quartile($komponeninternet, 0.75);
            $komponeninternet_q4 = $komponeninternets->max('harga_barang_beli');
            foreach ($komponeninternets as $ki) {
                $jenis_hargaki = '';
                if ($ki->harga_barang_beli <= $komponeninternet_q1) {
                    $jenis_hargaki = 'murah';
                } elseif ($ki->harga_barang_beli <= $komponeninternet_q2) {
                    $jenis_hargaki = 'sedang';
                } elseif ($ki->harga_barang_beli <= $komponeninternet_q3) {
                    $jenis_hargaki = 'mahal';
                } elseif ($ki->harga_barang_beli <= $komponeninternet_q4) {
                    $jenis_hargaki = 'sangat mahal';
                }
                // DataTraining::where('datamentah_id', $ki->id)->first()->update(['jenis_harga' => $jenis_hargaki]);
                $dtki = DataTraining::where('datamentah_id', $ki->id)->first();
                if ($dtki) {
                    $dtki->update(['jenis_harga' => $jenis_hargaki]);
                }
            }
        }

        $komponenkabels = DataMentah::where('kategori', 'komponen kabel')->where('isPrediksi', 1)->get();
        if (!$komponenkabels->isEmpty()) {
            $komponenkabel = array_column($komponenkabels->toArray(), 'harga_barang_beli');
            $komponenkabel_q1 = $this->quartile($komponenkabel, 0.25);
            $komponenkabel_q2 = $this->quartile($komponenkabel, 0.5);
            $komponenkabel_q3 = $this->quartile($komponenkabel, 0.75);
            $komponenkabel_q4 = $komponenkabels->max('harga_barang_beli');
            foreach ($komponenkabels as $kk) {
                $jenis_hargakk = '';
                if ($kk->harga_barang_beli <= $komponenkabel_q1) {
                    $jenis_hargakk = 'murah';
                } elseif ($kk->harga_barang_beli <= $komponenkabel_q2) {
                    $jenis_hargakk = 'sedang';
                } elseif ($kk->harga_barang_beli <= $komponenkabel_q3) {
                    $jenis_hargakk = 'mahal';
                } elseif ($kk->harga_barang_beli <= $komponenkabel_q4) {
                    $jenis_hargakk = 'sangat mahal';
                }
                // DataTraining::where('datamentah_id', $kk->id)->first()->update(['jenis_harga' => $jenis_hargakk]);
                $dtkk = DataTraining::where('datamentah_id', $kk->id)->first();
                if ($dtkk) {
                    $dtkk->update(['jenis_harga' => $jenis_hargakk]);
                }
            }
        }

        $komponenmaterials = DataMentah::where('kategori', 'komponen material')->where('isPrediksi', 1)->get();
        if (!$komponenmaterials->isEmpty()) {
            $komponenmaterial = array_column($komponenmaterials->toArray(), 'harga_barang_beli');
            $komponenmaterial_q1 = $this->quartile($komponenmaterial, 0.25);
            $komponenmaterial_q2 = $this->quartile($komponenmaterial, 0.5);
            $komponenmaterial_q3 = $this->quartile($komponenmaterial, 0.75);
            $komponenmaterial_q4 = $komponenmaterials->max('harga_barang_beli');
            foreach ($komponenmaterials as $km) {
                $jenis_hargakm = '';
                if ($km->harga_barang_beli <= $komponenmaterial_q1) {
                    $jenis_hargakm = 'murah';
                } elseif ($km->harga_barang_beli <= $komponenmaterial_q2) {
                    $jenis_hargakm = 'sedang';
                } elseif ($km->harga_barang_beli <= $komponenmaterial_q3) {
                    $jenis_hargakm = 'mahal';
                } elseif ($km->harga_barang_beli <= $komponenmaterial_q4) {
                    $jenis_hargakm = 'sangat mahal';
                }
                // DataTraining::where('datamentah_id', $km->id)->first()->update(['jenis_harga' => $jenis_hargakm]);
                $dtkm = DataTraining::where('datamentah_id', $km->id)->first();
                if ($dtkm) {
                    $dtkm->update(['jenis_harga' => $jenis_hargakm]);
                }
            }
        }
    }

    public function quartile($Array, $Quartile)
    {
        sort($Array);
        $pos = (count($Array) - 1) * $Quartile;

        $base = floor($pos);
        $rest = $pos - $base;

        if (isset($Array[$base + 1])) {
            return $Array[$base] + $rest * ($Array[$base + 1] - $Array[$base]);
        } else {
            return $Array[$base];
        }
    }

    public function labeling()
    {
        $c45 = new C45();
        $input = new DataInput;
        $trainings = DataTraining::where('isPrediksi', 0)->get();
        $atts = array();
        $count = 0;
        foreach ($trainings as $training) {
            $atts[$count++] = array(
                "jenis_pengadaan" => $training->jenis_pengadaan,
                "jenis_harga" => $training->jenis_harga,
                "jenis_stok" => $training->jenis_stok,
                "label" => $training->datamentah->label,
            );
        }

        // Initialize Data
        $input->setData($atts); // Set data from array
        $input->setAttributes(array('jenis_pengadaan', 'jenis_harga', 'jenis_stok', 'label')); // Set attributes of data

        // Initialize C4.5
        $c45->c45 = $input; // Set input data
        $c45->setTargetAttribute('label'); // Set target attribute
        $initialize = $c45->initialize(); // initialize

        // Build Output
        $buildTree = $initialize->buildTree(); // Build tree
        $arrayTree = $buildTree->toArray(); // Set to array
        $stringTree = $buildTree->toString(); // Set to string

        $label_trainings = DataTraining::where('isPrediksi', 1)->get();
        foreach ($label_trainings as $label_training) {
            $new_data = array(
                'jenis_pengadaan' => $label_training->jenis_pengadaan,
                'jenis_harga' => $label_training->jenis_harga,
                'jenis_stok' => $label_training->jenis_stok,
            );

            $new_label = $c45->initialize()->buildTree()->classify($new_data);
            DataMentah::find($label_training->datamentah_id)->update(['label' => $new_label]);
        }
    }
}

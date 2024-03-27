<?php

namespace App\Http\Controllers;

use App\Models\AlamatModel;
use App\Models\DebiturPasienModel;
use App\Models\groupItemModel;
use App\Models\kartuItemModel;
use App\Models\KontakModel;
use App\Models\PasienModel;
use App\Models\PersonModel;
use App\Models\satuanModel;
use App\Models\setupItemModel;
use App\Models\setupObatDetailModel;
use App\Models\setupObatModel;
use App\Models\stokItemModel;
use App\Models\tipePasienModel;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportController extends Controller
{
    //
    public function pasien(){
        set_time_limit(0);
        $data = DB::select("
        SELECT * FROM maspasien order by username offset 5893
        ",[]);
        foreach ($data as $key => $value) {
            DB::beginTransaction();
            try {
                //insert pasien 
                $person = new PersonModel();
                $person->id_jenis_identitas = 1;
                if(TRIM($value->no_ktp)!="-"){
                    $person->no_identitas = $value->no_ktp;
                }else{
                    $person->no_identitas = Str::uuid();
                }
                $person->no_kartu_keluarga = $value->no_kk;
                $person->nama_depan = $value->name;
                $person->nama_belakang = $value->nm_blk;
                if($value->jen_kel=="Wanita"){
                    $person->gender = "P";
                }else{
                    $person->gender = "L";
                }
                $person->tempat_lahir = $value->tmp_lhr;
                $person->tanggal_lahir = $value->tgl_lhr;
                $person->id_job_type = 22;
                $person->id_marital_status = 5;
                $person->id_agama = 7;
                $person->is_active = true;
                $person->user_created = 1;
                $person->time_created = date('Y-m-d H:i:s');
                $person->save();
                $person->id_person;

                $tipe = new tipePasienModel();
                $tipe->id_person = $person->id_person;
                $tipe->id_tipe_person =  1;
                $tipe->user_created = 1;
                $tipe->time_created = date('Y-m-d H:i:s');
                $tipe->save();

                $pasien = new PasienModel();
                $pasien->id_person = $person->id_person;
                $pasien->no_rekam_medis = $value->username;
                $pasien->visit_count = 0;
                $pasien->save();

                if(TRIM($value->no_bpjs) != "" OR TRIM($value->no_bpjs) != "-"){
                    $debitur_bpjs = new DebiturPasienModel();
                    $debitur_bpjs->id_person = $person->id_person;
                    $debitur_bpjs->id_debitur = 1;
                    $debitur_bpjs->no_member = $value->no_bpjs;
                    $debitur_bpjs->is_active = true;
                    $debitur_bpjs->is_default = true;
                    $debitur_bpjs->save();
                }

                $debitur_bpjs = new DebiturPasienModel();
                $debitur_bpjs->id_person = $person->id_person;
                $debitur_bpjs->id_debitur = 6;
                $debitur_bpjs->no_member = "";
                $debitur_bpjs->is_active = true;
                $debitur_bpjs->is_default = false;
                $debitur_bpjs->save();

                $alamat = new AlamatModel();
                $alamat->id_person = $person->id_person;
                $alamat->alamat_lengkap = $value->alamat;
                $alamat->is_active = true;
                $alamat->is_default = true;
                $alamat->user_created = 1;
                $alamat->time_created = date('Y-m-d H:i:s');
                $alamat->save();

                if(TRIM($value->hp)!= "-" OR TRIM($value->hp)!= "" OR $value->hp != null){
                    $kontak = new KontakModel();
                    $kontak->id_person = $person->id_person;
                    $kontak->hand_phone = $value->hp;
                    $kontak->is_active = true;
                    $kontak->is_default = true;
                    $kontak->user_created = 1;
                    $kontak->time_created = date('Y-m-d H:i:s');
                    $kontak->save();
                }
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                return $th;
            }
        }
        dd($data);
    }

    public function obat(){
        set_time_limit(0);
        DB::beginTransaction();
        try {
            $data = DB::select("
                select m.*,msgi.id_grup_item
                from masobat m inner join mm_setup_grup_item msgi on m.kategori = msgi.grup_item;
            ",[]);
            foreach($data as $key=>$value){
                $item = new setupItemModel();
                $item->id_grup_item =  $value->id_grup_item;
                $item->kode_item = $value->kode;
                $item->barcode = $value->kode;
                $item->nama_item = $value->nama;
                $item->kode_satuan = $value->satuan;
                $item->harga_beli_terakhir = $value->harga_hpp;
                $item->hpp_average = $value->harga_hpp;
                $item->is_active = true;
                $item->user_created = 1 ;
                $item->time_created = date('Y-m-d H:i:s');
                $item->save();

                $obat = new setupObatModel();
                $obat->id_item = $item->id_item;
                $obat->save();

                $obat_detail = new setupObatDetailModel();
                $obat_detail->id_item = $item->id_item;
                $obat_detail->harga_netto_apotek = $value->harga_jual;
                $obat_detail->tgl_berlaku = '2020-01-01';
                $obat_detail->is_active = true;
                $obat_detail->user_created = 1 ;
                $obat_detail->time_created = date('Y-m-d H:i:s');
                $obat_detail->save();

            }
            DB::commit();
            dd($data);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }

    public function stok(){
        set_time_limit(0);
        DB::beginTransaction();
        try {
            $data = DB::select("
                select msi.id_item,a.stok,msi.hpp_average
                from mm_setup_item msi inner join aastokobat a on msi.kode_item=a.kode_obat;
            ",[]);
            foreach ($data as $key => $value) {
                $stokItem = new stokItemModel();
                $stokItem->id_item = $value->id_item;
                $stokItem->id_stockroom = 2;
                $stokItem->qty_on_hand = $value->stok;
                $stokItem->qty_stok_kritis = 100;
                $stokItem->save();

                $kartustok = new kartuItemModel();
                $kartustok->tahun = date('Y');
                $kartustok->bulan = date('m');
                $kartustok->tanggal =date('Y-m-d');
                $kartustok->id_item = $value->id_item;
                $kartustok->id_stockroom = 2;
                $kartustok->nomor_ref_transaksi = "STOK AWAL";
                $kartustok->id_header_transaksi = 1;
                $kartustok->id_detail_transaksi = 1;
                $kartustok->stok_awal = 0;
                $kartustok->nominal_awal = 0;
                $kartustok->stok_masuk = $value->stok;
                $kartustok->nominal_masuk = $value->stok * $value->hpp_average;
                $kartustok->stok_keluar = 0;
                $kartustok->nominal_keluar = 0;
                $kartustok->stok_akhir = $value->stok;
                $kartustok->nominal_akhir = $value->stok * $value->hpp_average;
                $kartustok->keterangan = "import";
                $kartustok->user_inputed = 1;
                $kartustok->time_inputed = date('Y-m-d H:i:s');
                $kartustok->save();
            }
            
            DB::commit();
            dd($data);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }

    public function group_satuan(){
        set_time_limit(0);
        DB::beginTransaction();
        try {
            $group_dt = DB::select("
                select kategori from masobat group by kategori;
            ",[]);
            foreach ($group_dt as $key => $value) {
                $group = new groupItemModel();
                $group->id_tipe_item = 1;
                $group->kode_grup_item = TRIM($value->kategori);
                $group->grup_item = $value->kategori;
                $group->is_active = true;
                $group->user_created = 1 ;
                $group->time_created = date('Y-m-d H:i:s');
                $group->save();
            }
            $satuan_dt = DB::select("
                select satuan from masobat group by satuan;
            ",[]);
            foreach ($satuan_dt as $key => $value) {
                $satuan = new satuanModel();
                $satuan->kode_satuan = TRIM($value->satuan);
                $satuan->nama_satuan = TRIM($value->satuan);
                $satuan->is_active = true;
                $satuan->user_created = 1 ;
                $satuan->time_created = date('Y-m-d H:i:s');
                $satuan->save();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\KelasPerawatan;
use App\Models\SetupTarif;
use App\Models\SetupTarifBerlaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateTarifController extends Controller
{
    //
    public function update_tarif_jadi_kelas_1(){
        set_time_limit(0);
        DB::beginTransaction();
        try {
            $tarifs = SetupTarif::all();
            $kelass = KelasPerawatan::where('id_kelas','!=',1)->get();
            $kosong = [];
            foreach($tarifs as $tarif){
                //dd($tarif);
                $tarif_berlaku_kelas1 = SetupTarifBerlaku::where('id_setup_tarif',$tarif->id_setup_tarif)->where('id_kelas',1)->first();
                if($tarif_berlaku_kelas1==null){
                    array_push($kosong,$tarif->toArray());
                }else{
                    foreach($kelass as $kelas){
                        $tarif_berlaku_null = SetupTarifBerlaku::where('id_setup_tarif',$tarif->id_setup_tarif)->where('id_kelas',$kelas->id_kelas)->first();
                        if($tarif_berlaku_null==null){
                            $insert_tarif_berlaku = new SetupTarifBerlaku;
                            $insert_tarif_berlaku->id_setup_tarif = $tarif->id_setup_tarif;
                            $insert_tarif_berlaku->id_kelas = $kelas->id_kelas;
                            $insert_tarif_berlaku->tgl_berlaku = date('Y-m-d');
                            $insert_tarif_berlaku->nominal_tarif = $tarif_berlaku_kelas1->nominal_tarif;
                            $insert_tarif_berlaku->is_karcis_irja = $tarif_berlaku_kelas1->is_karcis_irja;
                            $insert_tarif_berlaku->is_karcis_irna = $tarif_berlaku_kelas1->is_karcis_irna;
                            $insert_tarif_berlaku->is_karcis_irda = $tarif_berlaku_kelas1->is_karcis_irda;
                            $insert_tarif_berlaku->is_akomodasi = $tarif_berlaku_kelas1->is_akomodasi;
                            $insert_tarif_berlaku->is_active = true;
                            $insert_tarif_berlaku->user_created = 1;
                            $insert_tarif_berlaku->time_created = date('Y-m-d H:i:s');
                            $insert_tarif_berlaku->save();
                        }
                    }
                    SetupTarifBerlaku::where('id_setup_tarif',$tarif->id_setup_tarif)->update([
                        'nominal_tarif'=> $tarif_berlaku_kelas1->nominal_tarif
                    ]);
                }
                // dd($tarif_berlaku_kelas1);
            }
            DB::commit();
            dd($kosong);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }
}

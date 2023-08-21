<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class malesNgodingController extends Controller
{
    //
    public function males_ngoding(Request $request){
        $data = DB::select("
            SELECT ordinal_position,column_name, data_type
            FROM information_schema.columns
            WHERE table_name = ? order by ordinal_position
        ",[$request->table]);
        
        $arr = [];
        $model = (object)$arr;
        
        $f_insert_param='';
        $f_insert_filed='';
        $f_insert_value='';
        $f_select = '';
        $last = count($data) - 1; 
        $id = $data[0]->column_name;
        $f_update_query='';
        $nm_table = $request->table;
        $nm_table = explode("_",$nm_table);
        $alias = '';
        foreach($nm_table as $char){
            $alias .= substr($char,0,1);
        }
        $f_getall_field = '';
        $dao_insert = '';
        foreach($data as $key=>$item){
            $model->{$item->column_name} = $this->type_data($item->data_type);
            // if(!$id==$item->column_name){
                $f_insert_param .= ($key==$last)?'_'.$item->column_name.' '.$item->data_type:'_'.$item->column_name.' '.$item->data_type.',';
                $f_select .= ($key==$last)?$item->column_name.' '.$item->data_type:$item->column_name.' '.$item->data_type.',';
                $f_insert_filed .= ($key==$last)?$item->column_name:$item->column_name.',';
                $f_insert_value .= ($key==$last)?'_'.$item->column_name:'_'.$item->column_name.',';
            // }
            $f_update_query .= ($key==$last)?$item->column_name.' = _'.$item->column_name:$item->column_name.' = _'.$item->column_name.',';
            $f_getall_field .= ($key==$last)?$alias.".".$item->column_name:$alias.".".$item->column_name.',';
            $dao_insert .= ($key==$last)?'_'.$item->column_name.' = param.'.$item->column_name:'_'.$item->column_name.' = param.'.$item->column_name.',
            ';
        }
        
        $f_insert ="
                create function ".$request->table."_insert($f_insert_param)returns TABLE(hasil integer)
                    language plpgsql
                as
                $$
                declare
                    lastid int = 0;
                    timenow timestamp = (select NOW()::TIMESTAMPTZ AT TIME ZONE 'Asia/Bangkok');
                BEGIN
                
                    insert into $request->table($f_insert_filed)
                    VALUES ($f_insert_value)
                    RETURNING $id INTO lastid;
                    
                    return query select lastid;
                
                END
                $$;
        ";
        
        $f_update = "
            create function ".$request->table."_update($f_insert_param)
                returns TABLE(hasil integer)
                language plpgsql
            as
            $$
            declare 
                    rcount int = 0;
                    lastid int = 0;
                
                BEGIN
                
                update 
                    $request->table
                set
                    $f_update_query
                where
                $id = _$id
                returning $id into lastid;
                get diagnostics rcount = ROW_COUNT;
                
                RETURN query select lastid;
            
            END
            $$;  
        ";
        
        $f_delete ="
            create function ".$request->table."_delete(_$id bigint)
                        returns TABLE(hasil integer)
                        language plpgsql
                    as
                    $$
                    declare
                        rcount int = 0;
                        lastid int = 0;
                        
                        BEGIN
                        
                        DELETE FROM $request->table
                        WHERE $id = _$id
                        returning $id into lastid;
                        
                        GET DIAGNOSTICS rcount = ROW_COUNT;
                        
                        if(rcount > 0)THEN
                            return query select 1;
                        else 
                            return query select 0;
                        end if;
                    
                        end;
                    
        $$;";
        
        $f_getall = "
            create function ".$request->table."_getall()
                returns TABLE($f_select)
                language plpgsql
            as
            $$
            BEGIN
            
                return query
                    select $f_getall_field
                    from ".$request->table." $alias;
            
            END
            $$;
        ";
        
        $f_getbyid = "
            create function ".$request->table."_getbyid(_$id bigint)
                returns TABLE($f_select)
                language plpgsql
            as
            $$
            BEGIN
            
                return query
                    select $f_getall_field
                    from ".$request->table." $alias
                            WHERE $alias.$id = _$id;
            
                RETURN;
            END
            $$;
        ";
        
        $dao_insert = "
            public async Task<short>insert(".$request->table."_insert_model param)
            {
                try
                {
                    return await this.db.executeScalarSp<short>(".'"'."".$request->table."_insert".'"'.", 
                        new
                        {
                            $dao_insert
                        });
                }
                catch (Exception)
                {
                    throw;
                }
            }
        ";
        
        $dao_getbyid ="
            public async Task<List<".$request->table."_get_model>> GetById(long $id)
            {
    	        try
    	        {
    		        return await this.db.QuerySPtoList<".$request->table."_get_model>(".'"'."".$request->table."_getbyid".'"'.", new
    		        {
    			        _$id = $id
    		        });
    	        }
    	        catch (Exception)
    	        {
    		        throw;
    	        }
            }
        ";
        
        $model = json_encode($model);
        
        $result = [
            'model'             => $model,
            'function_insert'   => $f_insert,
            'function_update'   => $f_update,
            'function_delete'   => $f_delete,
            'function_getall'   => $f_getall,
            'function_getbyid'  => $f_getbyid,
            'dao_insert'        => $dao_insert,
            'dao_getbyid'       => $dao_getbyid
        ];
        
        return view("malesngoding",$result);
    }
    
    protected function type_data($type){
        switch ($type) {
            case 'bigint':
            case 'integer': 
                return 0;
                break;
            case 'character varying':
                return 'string';
                break;
            case 'date':
                return date('Y-m-d');;
                break;
            case 'time without time zone':
                return date("h:i:s");
                break;
            case 'timestamp without time zone':
                return date("Y-m-d h:i:s");
                break;
            default:
                return 0;
          }
    }
}
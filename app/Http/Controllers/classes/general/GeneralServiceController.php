<?php

namespace App\Http\Controllers\classes\general;

use App\Http\Controllers\Controller;
use App\Http\traits\messages;
use App\Models\advertising_points_price;
use App\Models\listings_info;
use App\Services\notifications\pagiante_notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralServiceController extends Controller
{
    //
    public function delete_item(){
        $table = request('table');
        $id = request('id');
        if($table == 'listings_infos'){
            $l = listings_info::query()->find($id);
            $l->type = 'deleted_at';
            $l->save();
            listings_info::query()->find($id)->delete();
        }else if($table == 'countries' || $table == 'governments' || $table == 'cities' || $table == 'areas'){
            $item = advertising_points_price::query()->where('type','=',$table)
                ->where('place_id','=',$id)->first();
            if($item != null){
                $item->delete();
            }
            DB::table($table)->delete($id);
        } else {
            DB::table($table)->delete($id);
        }
        return messages::success_output([trans('messages.deleted_successfully')]);
    }


    public function paginate_notification_data(){
        $id = request('id') ?? 0;
        $type = request('type') ?? '';
        return pagiante_notifications::get_notifications($id,$type);
    }

    public function get_map_data_type(){
        $model =  '\\App\\Models\\'.request('type');
        $model = new $model();
        $data = $model->select('id',app()->getLocale().'_name as name')->get();
        return response()->json($data);

    }

    public function get_next_map_type(){
        $model =  '\\App\\Models\\'.request('type');
        $model = new $model();
        $data = $model->select('id',app()->getLocale().'_name as name')
            ->where(request('whereColumn'),'=',request('id'))->get();
        return response()->json($data);
    }
}

<?php

namespace App\Repositories;

use App\Models\HistoryDetail;

use App\Models\History;

use App\Models\DetailFile;

use DB;

use Illuminate\Http\UploadedFile;

use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;

class HistoryDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return HistoryDetail::class;
    }

    public function deleteWithFiles($detail_id){
        $detail = HistoryDetail::find($detail_id);

        if(empty($detail)) return [];

        foreach($detail->files as $file){
            Storage::disk('local')->delete($file->path);
            $file->delete();
        }

        $detail->delete();
    }

    public function updateWithFiles($attributes, $detail_id){
        $detail = HistoryDetail::find($detail_id);

        if(empty($detail)) return [];

        $files = $detail->files;
        
        $oldFiles = isset($attributes['old_files_id']) ? $attributes['old_files_id'] : [];
        foreach($files as $file){
            if(!in_array($file->id, $oldFiles)){
                Storage::disk('local')->delete($file->path);
                $file->delete();
            }
        }
        $newFiles = isset($attributes['file']) ? $attributes['file'] : [];
        //$newFiles = $attributes['file'];
        $history_id = $attributes['detail_id'];

        foreach($newFiles as $file){
            if($file instanceof UploadedFile){
                $name = str_replace(' ', '_',$file->getClientOriginalName());
                $path = 'files/histories/'.$history_id.'/'.time().'_'.$name;
                Storage::disk('local')->put($path, file_get_contents($file));
                $detailFile = DetailFile::create([
                    'path' => $path,
                    'name' => $name
                ]);
                $detailFile->history_detail_id = $history_id;
                $detailFile->save();

            }
        }

        $detail->description = $attributes['description'];

        $date = Carbon::createFromFormat('d-m-Y H:i', $attributes['date'])->toDateTimeString();
        $detail->date = $date; 
        $detail->save();
    }

    public function createWithFiles($attributes, $history_id){

        $history = History::find($history_id);

        if(empty($history)) return [];
        
        $historyDetail = [];

        DB::beginTransaction();

        try {    
            //create venta
            $historyDetail = HistoryDetail::create($attributes);    
            
            //attach history id
            $historyDetail->history_id = $history_id;
            
            if(isset($attributes['file']))
            {   
                foreach($attributes['file'] as $file){
                    if($file instanceof UploadedFile){
                        $name = str_replace(' ', '_',$file->getClientOriginalName());
                        $path = 'files/histories/'.$history_id.'/'.time().'_'.$name;
                        Storage::disk('local')->put($path, file_get_contents($file));
                        $detailFile = DetailFile::create([
                            'path' => $path,
                            'name' => $name
                        ]);
                        $detailFile->history_detail_id = $historyDetail->id;                       
                        $detailFile->save();

                     }
                }
            }

            $historyDetail->save();             
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
    
        return $historyDetail;
    }
}

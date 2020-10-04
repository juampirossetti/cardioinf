<?php

namespace App\Repositories;

use App\Models\DetailFile;

use DB;

use Illuminate\Http\UploadedFile;

use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Storage;

class HistoryFileRepository extends BaseRepository
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
        return DetailFile::class;
    }

    public function deleteFile($file_id){
        $file = DetailFile::find($file_id);

        if(empty($file)) return [];

        Storage::disk('local')->delete($file->path);
        $file->delete();

        return;
    }
}

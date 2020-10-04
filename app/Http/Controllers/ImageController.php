<?php
namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;

use App\Models\DetailFile;

class ImageController extends Controller {

    public function __construct()
    {

    } 
    
    public function showImage($history_id, $image_id) {
      $file = DetailFile::find($image_id);
      
      if($file->historyDetail->history->id != $history_id)
        return;
      
      $path = storage_path('app/'.$file->path);
      $type = "image";
      header('Content-Type:'.$type);
      header('Content-Length: ' . filesize($path));
      readfile($path);

    }

    public function downloadImage($history_id, $image_id) {
      $file = DetailFile::find($image_id);
      
      if($file->historyDetail->history->id != $history_id)
        return;
      
      $path = storage_path('app/'.$file->path);

      $type = 'image';
      $type2 = 'application/octet-stream';
      $headers = [
              'Content-Type' => $type,
           ];

      return response()->download($path, 'imagen.jpg', $headers);
    }

 }
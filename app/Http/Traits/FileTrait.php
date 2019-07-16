<?php namespace App\Http\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

trait FileTrait
{

    public function saveFile($request, $cliente,$campania,$pregon,$user,$camp)
    {
        try
        {
            //obtenemos el campo file definido en el formulario
            $file = $request->file($camp);

            //obtenemos el nombre del archivo
            $nombre = $request->file($camp)->getClientOriginalName();

            $path = $cliente.'/'.$campania.'/'.$pregon.'/'.$user.'/';

            //revisamos si existe el archivo
            $exists = Storage::disk('public')->exists($path.$nombre);

            if ($exists)
                $nombre = Carbon::now().'-'.$nombre;

            //indicamos que queremos guardar un nuevo archivo en el disco local
            Storage::disk('public')->put($path.$nombre,  File::get($file));

            return $nombre;
        }
        catch (\Exception $exception)
        {
            return false;
        }

    }

    public function saveFileBas64($nombre,$fileString)
    {
        try
        {
            $file = base64_decode($fileString);


            //revisamos si existe el archivo
            $extension = ".jpg";

            $exists = Storage::disk('public')->exists($nombre.$extension);

            if ($exists)
              $nombre = $nombre.'-'.Carbon::now();

            //indicamos que queremos guardar un nuevo archivo en el disco local
            Storage::disk('public')->put($nombre.$extension,  $file);

            $nombre = str_replace(" ","%20",$nombre);

            return $nombre.$extension;
        }
        catch (\Exception $exception)
        {
            return false;
        }

    }

    public function downloadFile($user,$pregon,$file)
    {
        $public_path = public_path();
        $url = $public_path.'/storage/'.$pregon.'/'.$user.'/'.$file;

        //verificamos si el archivo existe y lo retornamos
        if (Storage::exists($file))
        {
            return response()->download($url);
        }
        else
        {
            return Response()->json(["error" => "No se encuentra el archivo a descargar", "code" => 400],200);
        }

    }


}

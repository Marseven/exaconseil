<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

define('WIDTH_MIN', 300);     // Largeur max de l'image en pixels
define('HEIGHT_MIN', 300);
// todo: specified size to user

class FileController extends Controller
{

    /**
     * Display all annonce in specified category.
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    static function picture(UploadedFile $request)
    {
        $result = [];

        if ($request != NULL) {

            // On recupere les dimensions du fichier
            $infosImg = getimagesize($request->path());

            //dd($infosImg);

            if (($infosImg[0] >= WIDTH_MIN) && ($infosImg[1] >= HEIGHT_MIN)) {
                //get filename with extension
                $filenamewithextension = $request->getClientOriginalName();

                //get filename without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace($filename, " ", "");

                //get file extension
                $extension = $request->getClientOriginalExtension();

                //filename to store
                $filenametostore = $filename . '_' . time() . '_300x300.' . $extension;

                //Upload File
                $request->move(public_path('/upload/photo/original/'),  $filename . '.' . $extension);

                //Resize image here
                $originalpath = public_path('/upload/photo/original/' . $filename . '.' . $extension);
                $thumbnailpath = public_path('/upload/photo/traite/' . $filenametostore);

                $img = Image::make($originalpath)->fit(970, 1000, function ($constraint) {
                    $constraint->aspectRatio();
                })->interlace(true);
                $img->save($thumbnailpath);

                $filePath_originale = '/upload/photo/original/' . $filename . '.' . $extension;
                $filePath_traite = '/upload/photo/traite/' . $filenametostore;

                $result['state'] = true;
                $result['url'] =  $filePath_traite;
                $result['message'] = "Image uploadée avec succès!";

                return $result;
                //change the route as per your flow
            } else {
                $result['state'] = false;
                $result['message'] = "Les dimensions de votre images sont trop petites, les dimensions minimales recommandées sont 300px X 300px.";

                return $result;
            }
        } else {
            $result['state'] = false;
            $result['message'] = "Image n\'a pas été uploadé";

            return $result;
        }
    }

    static function avatar(UploadedFile $request)
    {
        $result = [];

        if ($request != NULL) {

            //get filename with extension
            $filenamewithextension = $request->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $filename = str_replace($filename, " ", "");

            //get file extension
            $extension = $request->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '_profil.' . $extension;

            //Upload File
            $request->move(public_path('/upload/avatar/'),  $filenametostore);

            $filePath_traite = '/upload/avatar/' . $filenametostore;

            $result['state'] = true;
            $result['url'] =  $filePath_traite;
            $result['message'] = "Fichier uploadé avec succès!";

            return $result;
            //change the route as per your flow
        } else {
            $result['state'] = false;
            $result['message'] = "Le fichier n\'a pas été uploadé";

            return $result;
        }
    }

    static function nominee(UploadedFile $request)
    {
        $result = [];

        if ($request != NULL) {

            //get filename with extension
            $filenamewithextension = $request->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $filename = str_replace($filename, " ", "");

            //get file extension
            $extension = $request->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '_profil.' . $extension;

            //Upload File
            $request->move(public_path('/upload/nominee/'),  $filenametostore);

            $filePath_traite = '/upload/nominee/' . $filenametostore;

            $result['state'] = true;
            $result['url'] =  $filePath_traite;
            $result['message'] = "Fichier uploadé avec succès!";

            return $result;
            //change the route as per your flow
        } else {
            $result['state'] = false;
            $result['message'] = "Le fichier n\'a pas été uploadé";

            return $result;
        }
    }

    static function piece(UploadedFile $request)
    {
        $result = [];

        if ($request != NULL) {

            //get filename with extension
            $filenamewithextension = $request->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $filename = str_replace($filename, " ", "");

            //get file extension
            $extension = $request->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename . '_' . time() . '_piece.' . $extension;

            //Upload File
            $request->move(public_path('/upload/piece/'),  $filenametostore);

            $filePath_traite = '/upload/piece/' . $filenametostore;

            $result['state'] = true;
            $result['url'] =  $filePath_traite;
            $result['message'] = "Fichier uploadé avec succès!";

            return $result;
            //change the route as per your flow
        } else {
            $result['state'] = false;
            $result['message'] = "Le fichier n\'a pas été uploadé";

            return $result;
        }
    }

    static function destroy($image)
    {
        Storage::disk('s3')->delete($image);
        return back()->withSuccess('Image a été supprimé avec succès.');
    }
}

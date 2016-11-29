<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\UploadNewFolderRequest;
use App\Services\UploadManager;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    protected $manager;

    public function __construct(UploadManager $manager)
    {
        $this->manager = $manager;
    }

    public function index(Request $request)
    {
        $folder = $request->get('folder');
        $data = $this->manager->folderInfo($folder);
        // dump($data);
        return view('admin.upload.index', $data);
    }

    public function createFolder(UploadNewFolderRequest $request)
    {
        $new_folder = $request->get('new_folder');
        $folder = $request0>get('folder') . '/'. $new_folder;

        $result = $this->manager->createDirectory($folder);

        if ($result === true) {
            return redirect()->back()->withSuccess("Folder '$new_folder' created.");
        }

        $error = $result ? : 'An error occurred creating directory';
        return redirect()->back()->withErrors([$error]);

    }

    public function deleteFile(Request $reqeust)
    {
        $del_file = $request->get('del_file');
        $path = $request->get('folder').'/'.$del_file;

        $result = $this->manager->deleteFile($path);

        if ($result === true) {
            return redirect()->back()->withSuccess("File '$del_file' delete");
        }

        $error = $result ? : 'error occurred';

        return redirect()->back()->withErrors([$error]);
    }

    public function deleteFolder(Request $request) 
    {
        $del_folder = $request->get('del_folder');
        $folder = $request->get('folder').'/'.$del_folder;

        $result = $this->manager->deleteDirectory($folder);

        if ($result === true) {
            return redirect()->back()->withSuccess('Folder '.$del_folder.' deleted');
        }

        $error = $result ? : 'error occurred';
        return redirect()->back()->withErrors([$error]);
    }

    public function uploadFile(UploadFileRequest $request)
    {
        $file = $_FILES['file'];
        $fileName = $request->get('file_name');
        $filename = $fileName ? : $file['name'];
        $path = str_finish($request->get('folder'), '/'). $fileName;

        $content = $this->manager->saveFile($path, $content);

        if($result === true) {
            return redirect()->back()->withSuccess("File '$fileName' uploaded");
        }

        $error = $result ? : "error occurred";
        return redirect()->back()->withErrors([$error]);
    }
}

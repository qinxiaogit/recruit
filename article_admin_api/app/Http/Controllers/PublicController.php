<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicController extends AppBaseController
{
    public function upload(Request $request)
    {
        $localName = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
//        explode('.')
        $pathFile = pathinfo($fileName);
        $remoteFile = 'upload/' . date("Ymd") . "/" . md5(time() . $pathFile['filename']) . '.' . $pathFile['extension'];

        $remoteUrl = $this->upload_image($remoteFile, file_get_contents($localName));
        return $this->sendResponse($remoteUrl, '上传成功');
    }


    function upload_image($path, $file)
    {
        if (!$path) return false;
        $disk = Storage::disk('qiniu');

        //将文件上传到七牛云，并且返回七牛云上相对路径
        $fileinfo = $disk->put($path, $file);
        //用相对路径来获取图片的完整路径
        return ['domain' => $disk->getUrl(''), 'path' => $path];
    }

}

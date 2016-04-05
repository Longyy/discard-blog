<?php
namespace App\Services;

use Carbon\Carbon;
use Dflydev\ApacheMimeTypes\PhpRepository;
use Illuminate\Support\Facades\Storage;

class UploadsManager
{
    protected $disk;
    protected $mimeDetect;

    public function __construct(PhpRepository $mimeDetect)
    {
        $this->disk = Storage::disk(config('blog.uploads.storage'));
        $this->mimeDetect = $mimeDetect;
    }

    /**
     * 返回目录下的文件及子目录信息等
     * @param $folder
     * @return array of [
     *     'folder' => 'path to current folder',
     *     'folderName' => 'name of just current folder',
     *     'breadCrumbs' => breadcrumb array of [ $path => $foldername ]
     *     'folders' => array of [ $path => $foldername] of each subfolder
     *     'files' => array of file details on each file in folder
     * ]
     */
    public function folderInfo($folder)
    {
        $folder = $this->cleanFolder($folder);

        $breadcrumbs = $this->breadcrumbs($folder); // 分解路径
        $slice = array_slice($breadcrumbs, -1); // 第倒数第一个元素并放到数组中
        $folderName = current($slice); // 取当前指针所指元素
        $breadcrumbs = array_slice($breadcrumbs, 0, -1); // 从第一个取到倒数第二个元素

        $subfolders = [];
        foreach(array_unique($this->disk->directories($folder)) as $subfolder) {
            $subfolders["/$subfolder"] = basename($subfolder);
        }

        $files = [];
        foreach($this->disk->files($folder) as $path) {
            $files[] = $this->fileDetails($path);
        }

        return compact(
            'folder',
            'folderName',
            'breadcrumbs',
            'subfolders',
            'files'
        );
    }

    /**
     * 整理文件名
     * @param $folder
     *
     */
    protected function cleanFolder($folder)
    {
        return '/' . trim(str_replace('..', '', $folder), '/');
    }

    /**
     * 返回当前目录路径
     * @param $folder
     */
    protected function breadcrumbs($folder)
    {
        $folder = trim($folder, '/');
        $crumbs = ['/' => 'root'];

        if(empty($folder)) {
            return $crumbs;
        }

        $folders = explode('/', $folder);
        $build = '';
        foreach($folders as $folder) {
            $build .= '/'.$folder;
            $crumbs[$build] = $folder;
        }

        return $crumbs;
    }

    /**
     * 返回文件详细信息数组
     * @param $path
     *
     */
    protected function fileDetails($path)
    {
        $path = '/' . ltrim($path, '/'); // 移除左侧/

        return [
            'name' => basename($path), // 返回带有文件扩展名的文件名
            'fullPath' => $path,
            'webPath' => $this->fileWebPath($path),
            'mimeType' => $this->fileMimeType($path),
            'size' => $this->fileSize($path),
            'modified' => $this->fileModified($path),
        ];
    }

    /**
     * 返回文件完整web路径
     * @param $path
     */
    public function fileWebPath($path)
    {
        $path = rtrim(config('blog.uploads.webpath'), '/') . '/' . ltrim($path, '/');
        return url($path);
    }

    /**
     * 返回文件mime类型
     * @param $path
     */
    public function fileMimeType($path)
    {
        return $this->mimeDetect->findType(
            pathinfo($path, PATHINFO_EXTENSION)
        );
    }

    /**
     * 返回文件大小
     * @param $path
     */
    public function fileSize($path)
    {
        return $this->disk->size($path);
    }

    /**
     * 返回文件最后修改时间
     * @param $path
     */
    public function fileModified($path)
    {
        return Carbon::createFromTimestamp(
            $this->disk->lastModified($path)
        );
    }

    /**
     * 创建目录
     * @param $folder
     * @return string
     */
    public function createDirectory($folder)
    {
        $folder = $this->cleanFolder($folder);
        if($this->disk->exists($folder)) {
            return "Folder '$folder' already exists.";
        }
        return $this->disk->makeDirectory($folder);
    }

    /**
     * 删除目录
     * @param $folder
     */
    public function deleteDirectory($folder)
    {
        $folder = $this->cleanFolder($folder);
        $filesFolders = array_merge(
            $this->disk->directories($folder),
            $this->disk->files($folder)
        );

        if(!empty($filesFolders)) {
            return "Directory must be empty to delete it.";
        }

        return $this->disk->deleteDirectory($folder);
    }

    public function deleteFile($path)
    {
        $path = $this->cleanFolder($path);
        if(!$this->disk->exists($path)) {
            return "File does not exist.";
        }
        return $this->disk->delete($path);
    }

    public function saveFile($path, $content)
    {
        $path = $this->cleanFolder($path);
        if ($this->disk->exists($path)) {
            return "File already exists.";
        }
        return $this->disk->put($path, $content);
    }

}
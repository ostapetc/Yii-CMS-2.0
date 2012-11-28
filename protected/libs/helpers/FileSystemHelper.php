<?

class FileSystemHelper
{
    public static function isAllowForUnlink($file)
    {
        $allow_extensions = array(
            'jpg', 'jpeg', 'png', 'gif'
        );
        $info = pathinfo($file);
        if (in_array($info['extension'], $allow_extensions))
        {
            return true;
        }

        return false;
    }


    public static function getUniqFileName($file, $dir)
    {
        $dir = trim('/', $dir);

        if (mb_strpos($dir, $_SERVER['DOCUMENT_ROOT']) === false)
        {
            $dir = $_SERVER['DOCUMENT_ROOT'] . $dir . '/';
        }

        $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $name = md5(rand(0, getrandmax()) . uniqid("", true) . uniqid("", true) . $file) . '.' . $ext;

        if (file_exists($dir . $name))
        {
            self::getUniqFileName($name, $dir);
        }

        return $name;
    }

    /**
     * Delete directory fast and recursive
     *
     * @static
     * @param $path
     */
    public static function deleteDirRecursive($path)
    {
        foreach(glob($path . '*', GLOB_MARK) as $file) {
            $is_dir = substr($file, -1) == DS;
            $is_dir ? self::removeDirectory($file) : unlink($file);
        }
        rmdir($path);
    }


    public static function findSimilarFiles($dir, $file)
    {
        $dir_files     = scandir($dir);
        $similar_files = array();

        foreach ($dir_files as $dir_file)
        {
            if ($dir_file == '.' || $dir_file == '..' || $dir_file == $file)
            {
                continue;
            }

            if (strpos($dir_file, $file) !== false)
            {
                $similar_files[] = $dir_file;
            }
        }

        return $similar_files;
    }


    public static function deleteFileWithSimilarNames($dir, $file)
    {
        //$dir = trim($dir, '/');
        $files = array_merge(array($file), self::findSimilarFiles($dir, $file));

        self::unlinkFiles($dir, $files);
    }


    public static function unlinkFiles($dir, $files)
    {
        foreach ($files as $file)
        {
            $file_path = $dir . '/' . $file;

            if (file_exists($file_path))
            {
                unlink($file_path);
            }
        }
    }

}

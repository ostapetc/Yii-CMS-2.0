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
        $dir = trim($dir, '/');
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


    /************FileBalance***********/

    /**
     * Простой балансировщик файлов. Занимается равномерным распределением файлов по директориям.
     * Если в одной директории будет накапливаться слишком много файлов, то время поиска файла в этой директории
     * будет сильно расти.
     *
     * По умолчанию глубина вложенности подпапок $depth = 1
     * Для каждого файлы вызывается md5(uniqid(""))
     * из первых $depth*2 символов создает $depth двубуквенных директорий и файл перемещается туда .
     * За счет нормальности распределения md5(uniqid("")) файлы будут распределяться равномерно.
     * Получаем 256 возможных директорий, при количестве файлов в каждой
     * директории до 1000 файлов, не имеем проблем с производительностью.
     * Значит каждое хранилище(параметр $base_target_directory) обеспечивает быстрый доступ к 1/4 миллиона файлов.
     *
     * Накладные расходы:
     * EXT3 занимает 4КБ(служебной информации) на директорию.
     * Значит одно хранилище займет: 1мб при $depth = 1, 256мб при $depth = 2
     *
     * Возможный хранимый объем:
     * 1000 файлов по 1мб на директорию: 256ГБ при $depth = 1, 65ТБ при $depth = 2
     *
     * Устанавливать $depth больше 2-х не рекомендуется, сильно возрастают накладные расходы на хранение структуры каталогов.
     */
    public static $saveOriginalFileName = false;  //если true, конечно же будут проблемы с нелатиницей, пробелами и пр.
    public static $depth = 1;


    public static function moveToVault($src_file, $base_vault_directory, $as_array = false)
    {
        if (!is_file($src_file))
        {
            return false;
        }

        list($target_path, $target_file) = self::getVaultPathAndName($src_file, $base_vault_directory);

        if (!is_dir('./' . $target_path))
        {
            @mkdir('./' . $target_path, 0755, true);
        }

        @rename('./' . $src_file, './' . $target_path . '/' . $target_file);

        if ($as_array)
        {
            return array(
                $target_path, $target_file
            );
        }
        else
        {
            return $target_path . '/' . $target_file;
        }
    }


    public static function getVaultPathAndName($src_file, $base_vault_directory, $target_file_name = null)
    {
        $id = md5(uniqid("", true));

        //from 4 symbol construct 2 folders
        $folder_id = substr($id, 0, self::$depth * 2);
        $folder_id = implode('/', str_split($folder_id, 2));
        //new file name
        if ($target_file_name === null)
        {
            if (self::$saveOriginalFileName)
            {
                $target_file_name = pathinfo($src_file, PATHINFO_BASENAME);
            }
            else
            {
                $target_file_name =
                    substr($id, self::$depth * 2) . '.' . pathinfo($src_file, PATHINFO_EXTENSION);
            }
        }

        $target_path = $base_vault_directory . '/' . $folder_id;
        $target_file = self::vaultResolveCollision($target_path, $target_file_name);

        return array(
            $target_path, $target_file
        );
    }


    public static function vaultResolveCollision($path, $file)
    {
        while (is_file('./' . $path . '/' . $file))
        {
            $file = rand(0, 9) . $file;
        }
        return $file;
    }
}

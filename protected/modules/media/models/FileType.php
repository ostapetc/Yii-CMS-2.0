<?php
class FileType
{
    const VIDEO   = 'video';
    const AUDIO   = 'audio';
    const ARCHIVE = 'archive';
    const IMAGE   = 'image';
    const EXCEL   = 'excel';
    const WORD    = 'word';
    const BOOKS   = 'books';


    public static $archiveExtensions = [
        'zip',
        'rar',
        'tar',
        'gz'
    ];
    public static $imageExtensions = [
        'png',
        'jpeg',
        'jpg',
        'tiff',
        'ief',
        'gif'
    ];

    public static $excelExtensions = [
        'xl',
        'xla',
        'xlb',
        'xlc',
        'xld',
        'xlk',
        'xll',
        'xlm',
        'xls',
        'xlt',
        'xlv',
        'xlw'
    ];
    public static $audioExtensions = [
        'wma',
        'mp3'
    ];
    public static $wordExtensions = [
        'doc',
        'dot',
        'docx'
    ];
    public static $videoExtensions = [
        'flv',
        'avi',
        'mpeg',
        'wmv',
        'mp4',
    ];

    public static $bookExtensions = [
        'pdf',
        'djvu'
    ];


}
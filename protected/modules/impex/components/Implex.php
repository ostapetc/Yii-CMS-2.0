<?php

class Implex 
{
	public static function exportXLS($title, $array_data, $labels, $file_name) 
	{	
		$file_path = self::getDir() . $file_name . '.xls';

        //if (!file_exists($file_path))
        //{
            $letters = range('A', 'Z');

            $phpExcelPath = Yii::getPathOfAlias('application.libs.phpexcel.Classes');
            spl_autoload_unregister(array('YiiBase','autoload'));
            include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

            $objPHPExcel = new PHPExcel();

            $sheet = $objPHPExcel->setActiveSheetIndex(0);

            $i = 0;
            
            $sheet->setCellValue("A4", $title);
            $sheet->getStyle("A4")->applyFromArray(array("font" => array("bold" => true)));
            $sheet->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
            $sheet->mergeCells('A4:E4');        
            
            $num_titles = array("A7", "B7", "C7", "D7", "E7");
            foreach ($num_titles as $n => $cell) 
            {
                $sheet->setCellValue($cell, ++$n);
                $sheet->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }          
            
            foreach ($labels as $label)
            {
                $cell = "{$letters[$i]}6";

                $sheet->setCellValue($cell, $label);
                $sheet->getStyle($cell)->applyFromArray(array("font" => array("bold" => true)));
                $sheet->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
                $i++;
            }

            $sheet = $objPHPExcel->setActiveSheetIndex(0);
            
            $sheet->getColumnDimension('A')->setWidth(6);
            $sheet->getColumnDimension('B')->setWidth(38);   
            $sheet->getColumnDimension('C')->setWidth(38);
            $sheet->getColumnDimension('D')->setWidth(38);
            $sheet->getColumnDimension('E')->setWidth(20);
            
            $object_index = 8;

            foreach ($array_data as $data)
            {
                $param_index = 0;

                foreach ($data as $ind => $value)
                {
                    $cell = "{$letters[$param_index]}{$object_index}";    
                    
                    $sheet->setCellValue($cell, $value);                 
                    
                    if ($ind == 4 or $ind == 0) 
                    {
                        $sheet->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    }

                    $param_index++;
                }

                $object_index++;
            }

            $styleArray = array(
              'borders' => array(
                'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
                )
              )
            );

            $objPHPExcel->getActiveSheet()->getStyle('A6:E' . --$object_index)->applyFromArray($styleArray);

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save($file_path);
            @chmod($file_path, 0777);

            spl_autoload_register(array('YiiBase','autoload'));
       // }
        
        $path_info = pathinfo($file_path);
        
        $data = file_get_contents($file_path);
        self::sendHeader($path_info["basename"], strlen($data), 'vnd.ms-excel');
        echo $data;
	}


    private static function sendHeader($filename, $length, $type='octet-stream')
    {
        header("Content-type: application/$type");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-length: $length");
        header("Pragma: no-cache");
        header("Expires: 0");
    }


    private static function getDir()
    {
        return $_SERVER["DOCUMENT_ROOT"] . "upload/implex/";
    }


    public static function refreshXLS($file_name)
    {
        $file_path = self::getDir() . $file_name . '.xls';
        if (file_exists($file_path))
        {
            unlink($file_path);
        }
    }
}

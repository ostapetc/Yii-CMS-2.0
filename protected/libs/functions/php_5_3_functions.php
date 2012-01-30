<?php
if (function_exists('get_called_class') === false)
{
    function get_called_class()
    {
        $bt    = debug_backtrace();
        $lines = file($bt[1]['file']);
        preg_match('/([a-zA-Z0-9\_]+)::'.$bt[1]['function'].'/', $lines[$bt[1]['line'] - 1], $matches);
        return $matches[1];
    }
}

if (function_exists('lcfirst') === false)
{
    function lcfirst($str)
    {
        $str[0] = strtolower($str[0]);
        return $str;
    }

}


function imagecreatefrombmp($filename)
{
 //Ouverture du fichier en mode binaire
   if (! $f1 = fopen($filename,"rb")) return FALSE;

 //1 : Chargement des ent�tes FICHIER
   $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
   if ($FILE['file_type'] != 19778) return FALSE;

 //2 : Chargement des ent�tes BMP
   $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
                 '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
                 '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
   $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
   if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
   $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
   $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
   $BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
   $BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
   $BMP['decal'] = 4-(4*$BMP['decal']);
   if ($BMP['decal'] == 4) $BMP['decal'] = 0;

 //3 : Chargement des couleurs de la palette
   $PALETTE = array();
   if ($BMP['colors'] < 16777216)
   {
    $PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
   }

 //4 : Cr�ation de l'image
   $IMG = fread($f1,$BMP['size_bitmap']);
   $VIDE = chr(0);

   $res = imagecreatetruecolor($BMP['width'],$BMP['height']);
   $P = 0;
   $Y = $BMP['height']-1;
   while ($Y >= 0)
   {
    $X=0;
    while ($X < $BMP['width'])
    {
     if ($BMP['bits_per_pixel'] == 24)
        $COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
     elseif ($BMP['bits_per_pixel'] == 16)
     {
        $COLOR = unpack("n",substr($IMG,$P,2));
        $COLOR[1] = $PALETTE[$COLOR[1]+1];
     }
     elseif ($BMP['bits_per_pixel'] == 8)
     {
        $COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
        $COLOR[1] = $PALETTE[$COLOR[1]+1];
     }
     elseif ($BMP['bits_per_pixel'] == 4)
     {
        $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
        if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
        $COLOR[1] = $PALETTE[$COLOR[1]+1];
     }
     elseif ($BMP['bits_per_pixel'] == 1)
     {
        $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
        if     (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
        elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
        elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
        elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
        elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
        elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
        elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
        elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
        $COLOR[1] = $PALETTE[$COLOR[1]+1];
     }
     else
        return FALSE;
     imagesetpixel($res,$X,$Y,$COLOR[1]);
     $X++;
     $P += $BMP['bytes_per_pixel'];
    }
    $Y--;
    $P+=$BMP['decal'];
   }

 //Fermeture du fichier
   fclose($f1);

 return $res;
}

function imagebmp(&$img, $filename = false)
{
	$wid = imagesx($img);
	$hei = imagesy($img);
	$wid_pad = str_pad('', $wid % 4, "\0");

	$size = 54 + ($wid + $wid_pad) * $hei * 3; //fixed

	//prepare & save header
	$header['identifier']		= 'BM';
	$header['file_size']		= dword($size);
	$header['reserved']			= dword(0);
	$header['bitmap_data']		= dword(54);
	$header['header_size']		= dword(40);
	$header['width']			= dword($wid);
	$header['height']			= dword($hei);
	$header['planes']			= word(1);
	$header['bits_per_pixel']	= word(24);
	$header['compression']		= dword(0);
	$header['data_size']		= dword(0);
	$header['h_resolution']		= dword(0);
	$header['v_resolution']		= dword(0);
	$header['colors']			= dword(0);
	$header['important_colors']	= dword(0);

	if ($filename)
	{
	    $f = fopen($filename, "wb");
	    foreach ($header AS $h)
	    {
	    	fwrite($f, $h);
	    }

		//save pixels
		for ($y=$hei-1; $y>=0; $y--)
		{
			for ($x=0; $x<$wid; $x++)
			{
				$rgb = imagecolorat($img, $x, $y);
				fwrite($f, byte3($rgb));
			}
			fwrite($f, $wid_pad);
		}
		fclose($f);
	}
	else
	{
	    foreach ($header AS $h)
	    {
	    	echo $h;
	    }

		//save pixels
		for ($y=$hei-1; $y>=0; $y--)
		{
			for ($x=0; $x<$wid; $x++)
			{
				$rgb = imagecolorat($img, $x, $y);
				echo byte3($rgb);
			}
			echo $wid_pad;
		}
	}
}

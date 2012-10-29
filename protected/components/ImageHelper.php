<?
ini_set("memory_limit", '1G'); //GD - memory killer
class ImageHelper
{
    public static function placeholder(array $size, $text = null, $only_url = false)
    {
        $dim = $size['width'].'x'.$size['height'];
        $text = $text ? $text : $dim;
        $url = 'http://placehold.it/'.$dim.'&text='.urlencode($text);
        if ($only_url)
        {
            return $url;
        }
        else
        {
            return CHtml::image($url, $text, $size);
        }
    }

    public static function thumbSrc($dir, $file, array $size, $crop = false)
    {
        return static::process($dir, $file, $size, $crop);
    }

    public static function thumb($dir, $file, array $size, $crop = false)
    {
        return CHtml::image(static::process($dir, $file, $size, $crop), '', $size);
    }
 

    public static function process($dir, $file, array $size, $crop = false)
    {
        if (!$file)
        {
            return null;
        }

        $width  = isset($size['width']) && is_numeric($size['width']) ? $size['width'] : 0;
        $height = isset($size['height']) && is_numeric($size['height']) ? $size['height'] : 0;

        //normalize dir
        $doc_root = $_SERVER['DOCUMENT_ROOT'];

        if (substr($dir, 0, strlen($doc_root)) !== $doc_root)
        {
            $dir = $doc_root . $dir;
        }

        $dir       = rtrim($dir, '/') . '/';
        $path_info = pathinfo($file);

        $thumb_name = $width . "x" . $height;

        if ($crop)
        {
            $thumb_name .= "_crop";
        }


        $thumb_name .= "_" . $path_info["basename"];
        $thumb_path = $dir . $thumb_name;
        $file_path  = $dir . $file;

        if (!file_exists($thumb_path))
        {
            if (!file_exists($file_path))
            {
                return null;
            }

            $image = Yii::app()->image->load($dir . $file);

            if ($crop)
            {
                if (!$width && $height)
                {
                    $width = $height;
                }
                elseif (!$height && $width)
                {
                    $height = $width;
                }

                $image_size = getimagesize($file_path);
                if ($image_size[0] < $image_size[1])
                {
                    $image->resize($width, 0);
                }
                else
                {
                    $image->resize(0, $height);
                }

                $image->crop($width, $height);
            }
            else
            {
                $image->resize($width, $height);
            }
            $image->save($thumb_path);

            @chmod($thumb_path, 0777);
        }

        $thumb_path = str_replace($_SERVER["DOCUMENT_ROOT"], "", $thumb_path);
        $thumb_path = '/' . ltrim($thumb_path, '/');

        return $thumb_path;
    }

}



/**
 * Water marking class
 *
 *  $image = new ImageWatermark();
 * $image->init( array(
 * 					'image_file'	=> $img,
 * 					'margin' => 5,
 * 			)		);
 *
 * if( $image->error )
 * {
 * 	print $image->error;exit;
 * }
 *
 * // Add a watermark
 * $image->addWatermark( $watermark );
 * $image->addWatermark( $watermark, 'bottom-left' );
 * //$image->writeImage();
 * $image->displayImage();
 *
 *
 */
class ImageWatermark {
	/**
	 * Error string
	 * @var		string
	 */
	public $error;
	/**
	 * Allowed type sarray
	 * @var	array
	 */
	public $imageTypes = array( 'gif', 'jpeg', 'jpg', 'jpe', 'png' );

	/**
	 * Image resource
	 * @var		resource	Image resource
	 */
	private $image			= null;

	/**
	 * Image quality settings
	 * @var		array 		Image quality settings
	 */
	public $quality			= array( 'png' => 8, 'jpg' => 75 );
	/**
	 * Image extension
	 * @var	string
	 */
	public $imageExtension;

	/**
	 * Image Path
	 *
	 * @var		string		Path to image
	 */
	protected $imagePath		= '';

	/**
	 * Image File
	 *
	 * @var		string		Image file to work with
	 */
	protected $imageFile		= '';

	/**
	 * Image path + file
	 *
	 * @var		string		Full image path and filename
	 */
	protected $imageFull		= '';

	/**
	 * Image dimensions
	 *
	 * @var		array		Original Image Dimensions
	 */
	protected $origDimensions	= array( 'width' => 0, 'height' => 0 );

	/**
	 * Image current dimensions
	 *
	 * @var		array		Curernt/New Image Dimensions
	 */
	public $currentDeminsions		= array( 'width' => 0, 'height' => 0 );
	/**
	 * Image resource
	 * @var		resource	Image resource
	 */
	public $position = 'bottom-right';
	/**
	 * Image resource
	 * @var		resource	Image resource
	 */
	public $positionTypes = array('center', 'top-left', 'top-right', 'bottom-right', 'bottom-left', 'top-center', 'center-right', 'center-bottom', 'center-left');
	/**
	 * Image resource
	 * @var		resource	Image resource
	 */
	public $margin = 1;

	/**
	 * Initiate image handler, perform any necessary setup
	 *
	 * @access	public
	 * @param	array 		Necessary options to init module [image_path, image_file]
	 * @return	boolean		Initiation successful
	 */
	public function init( $opts=array() )
	{

		if( !isset($opts['image_file']) OR !$opts['image_file'] )
		{
			$this->error		= 'no_image_file';
			return false;
		}

	 	//---------------------------------------------------------
	 	// Store paths
	 	//---------------------------------------------------------

		//$this->imagePath		= $this->_cleanPaths( $opts['image_path'] );
		$this->imageFile		= $opts['image_file'];
		$this->imageFull		= $this->imageFile;

	 	//---------------------------------------------------------
	 	// Get extension
	 	//---------------------------------------------------------

		$this->imageExtension	= strtolower(pathinfo( $this->imageFile, PATHINFO_EXTENSION ));

	 	//---------------------------------------------------------
	 	// Verify this is a valid image type
	 	//---------------------------------------------------------

		if( !in_array( $this->imageExtension, $this->imageTypes ) )
		{
			$this->error		= 'image_not_supported';
			return false;
		}

		//---------------------------------------------------------
		// Quality values
		//---------------------------------------------------------

		if( isset($opts['jpg_quality']) AND $opts['jpg_quality'] )
		{
			$this->quality['jpg']	= $opts['jpg_quality'];
		}

		if( isset($opts['png_quality']) AND $opts['png_quality'] )
		{
			$this->quality['png']	= $opts['png_quality'];
		}

		if( isset($opts['margin']) AND $opts['margin'] )
		{
			$this->margin	= $opts['margin'];
		}

		if( isset($opts['position']) AND $opts['position'] )
		{
			$this->position	= $opts['position'];
		}

	 	//---------------------------------------------------------
	 	// Get and remember dimensions
	 	//---------------------------------------------------------

		$dimensions = @getimagesize( $this->imageFull );

		$this->origDimensions	= array( 'width' => $dimensions[0], 'height' => $dimensions[1] );
		$this->currentDeminsions	= $this->origDimensions;

	 	//---------------------------------------------------------
	 	// Create image resource
	 	//---------------------------------------------------------

		switch( $this->imageExtension )
		{
			case 'gif':
				$this->image = @imagecreatefromgif( $this->imageFull );
			break;

			case 'jpeg':
			case 'jpg':
			case 'jpe':
				$this->image = @imagecreatefromjpeg( $this->imageFull );
			break;

			case 'png':
				$this->image = @imagecreatefrompng( $this->imageFull );
				imagealphablending( $this->image, TRUE );
				imagesavealpha( $this->image, TRUE );
			break;
		}

		if( !$this->image )
		{
			//-----------------------------------------
			// Fallback
			// @see http://forums.invisionpower.com/index.php?app=tracker&showissue=17836
			//-----------------------------------------

			if( $this->image = @imagecreatefromstring( file_get_contents( $this->imageFull ) ) )
			{
				return true;
			}

			$this->error		= 'no_full_image';
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Cleans up paths, generates var $in_file_complete
	 *
	 * @access	protected
	 * @param	string		Path to clean
	 * @return 	string		Cleaned path
	 */
	protected function _cleanPaths( $path='' )
	{
	 	//---------------------------------------------------------
	 	// Remove trailing slash
	 	//---------------------------------------------------------

		return rtrim( $path, '/' );
	}

	/**
	 * Write image to file
	 *
	 * @access	public
	 * @param	string 		File location (including file name)
	 * @return	boolean		File write successful
	 */
	public function writeImage( $file=null )
	{
		$path = $file ? $file : $this->imageFile;
	 	//---------------------------------------------------------
	 	// Remove image if it exists
	 	//---------------------------------------------------------

		if( file_exists( $path ) )
		{
			@unlink( $path );
		}

	 	//---------------------------------------------------------
	 	// Write file and verify
	 	//---------------------------------------------------------

		switch( $this->imageExtension )
		{
			case 'gif':
				@imagegif( $this->image, $path );
			break;

			case 'jpeg':
			case 'jpg':
			case 'jpe':
				@imagejpeg( $this->image, $path, $this->quality['jpg'] );
			break;

			case 'png':
				@imagepng( $this->image, $path, $this->quality['png'] );
			break;
		}

		if( !file_exists( $path ) )
		{
	 		$this->error		= 'unable_to_write_image';
		 	return false;
	 	}

	 	//---------------------------------------------------------
	 	// Chmod 777
	 	//---------------------------------------------------------

	 	@chmod( $path, 0777 );

	 	//---------------------------------------------------------
	 	// Destroy image resource
	 	//---------------------------------------------------------

	 	@imagedestroy( $this->image );

	 	return true;
	}

    /**
	 * Print image to screen
	 *
	 * @access	public
	 * @return	void		Image printed and script exits
	 */
	public function displayImage()
	{
	 	//---------------------------------------------------------
	 	// Send appropriate header and output image
	 	//---------------------------------------------------------

		switch( $this->imageExtension )
		{
			case 'gif':
				@header('Content-type: image/gif');
				@imagegif( $this->image );
			break;

			case 'jpeg':
			case 'jpg':
			case 'jpe':
				@header('Content-Type: image/jpeg' );
				@imagejpeg( $this->image, null, $this->quality['jpg'] );
			break;

			case 'png':
				@header('Content-Type: image/png' );
				@imagepng( $this->image, null, $this->quality['png'] );
			break;
		}

	 	//---------------------------------------------------------
	 	// Destroy image resource
	 	//---------------------------------------------------------

	 	@imagedestroy( $this->image );

		exit;
	}


    /**
	 * Add watermark to image
	 *
	 * @access	public
	 * @param	string 		Watermark image path
	 * @param	integer		[Optional] Opacity 0-100
	 * @return	boolean		Watermark addition successful
	 */
	public function addWatermark( $path, $position=null, $margin=null, $opacity=100 )
	{
	 	//---------------------------------------------------------
	 	// Verify input
	 	//---------------------------------------------------------

		if( !$path )
		{
			$this->error		= 'no_watermark_path';
			return false;
		}

		$type		= strtolower( pathinfo( basename($path), PATHINFO_EXTENSION ) );
		$opacity	= $opacity > 100 ? 100 : ( $opacity < 0 ? 1 : $opacity );

		if( !in_array( $type, $this->imageTypes ) )
		{
			$this->error		= 'bad_watermark_type';
			return false;
		}

	 	//---------------------------------------------------------
	 	// Create resource from watermark and verify
	 	//---------------------------------------------------------

		switch( $type )
		{
			case 'gif':
				$mark = @imagecreatefromgif( $path );
			break;

			case 'jpeg':
			case 'jpg':
			case 'jpe':
				$mark = @imagecreatefromjpeg( $path );
			break;

			case 'png':
				$mark = @imagecreatefrompng( $path );
			break;
		}

		if( !$mark )
		{
	 		$this->error		= 'image_creation_failed';
		 	return false;
	 	}

	 	//---------------------------------------------------------
	 	// Alpha blending..
	 	//---------------------------------------------------------

		switch( $this->imageExtension )
		{
			case 'jpeg':
			case 'jpg':
			case 'jpe':
			case 'png':
				@imagealphablending( $this->image, TRUE );
			break;
		}

	 	//---------------------------------------------------------
	 	// Get dimensions of watermark
	 	//---------------------------------------------------------

	 	$img_info		= @getimagesize( $path );
	 	$locate_x		= $this->currentDeminsions['width'] - $img_info[0];
	 	$locate_y		= $this->currentDeminsions['height'] - $img_info[1];

		// Watermark widths
		$watermarkWidth = $img_info[0];
		$watermarkHeight = $img_info[1];

		// Do we need to change the position and margin
		if($position) {
			$this->position = $position;
		}

		if($margin) {
			$this->margin = $margin;
		}

	 	// Figure out position
	 	switch($this->position) {
	 		case 'top-left':
	 			$watermarkPositionX = 0 + $this->margin;
        		$watermarkPositionY = 0 + $this->margin;
	 		break;

	 		case 'top-right':
	 			$watermarkPositionX = $this->currentDeminsions['width'] - $watermarkWidth - $this->margin;
        		$watermarkPositionY = 0 + $this->margin;
	 		break;

	 		case 'bottom-right':
	 			$watermarkPositionX = $this->currentDeminsions['width'] - $watermarkWidth - $this->margin;
        		$watermarkPositionY = $this->currentDeminsions['height'] - $watermarkHeight - $this->margin;
	 		break;

	 		case 'bottom-left':
	 			$watermarkPositionX = 0 + $this->margin;
        		$watermarkPositionY = $this->currentDeminsions['height'] - $watermarkHeight - $this->margin;
	 		break;

	 		case 'top-center':
	 			$watermarkPositionX = ( ( $this->currentDeminsions['width'] - $watermarkWidth ) / 2 );
        		$watermarkPositionY = 0 + $this->margin;
	 		break;

	 		case 'center-right':
	 			$watermarkPositionX = $this->currentDeminsions['width'] - $watermarkWidth - $this->margin;
        		$watermarkPositionY = ( $this->currentDeminsions['height'] / 2 ) - ( $watermarkHeight / 2 ) - $this->margin;
	 		break;

	 		case 'center-bottom':
	 			$watermarkPositionX = ( ( $this->currentDeminsions['width'] - $watermarkWidth ) / 2 );
        		$watermarkPositionY = $this->currentDeminsions['height'] - $watermarkHeight - $this->margin;
	 		break;

	 		case 'center-left':
	 			$watermarkPositionX = 0 + $this->margin;
        		$watermarkPositionY = ( $this->currentDeminsions['height'] / 2 ) - ( $watermarkHeight / 2 ) - $this->margin;
	 		break;

	 		case 'center':
	 		default:
	 			$watermarkPositionX = ( $this->currentDeminsions['width'] / 2 ) - ( $watermarkWidth / 2 );
        		$watermarkPositionY = ( $this->currentDeminsions['height'] / 2 ) - ( $watermarkHeight / 2 );
	 		break;
	 	}

	 	//var_dump($locate_x, $watermarkPositionX, $locate_y, $watermarkPositionY);exit;

	 	//---------------------------------------------------------
	 	// Merge watermark image onto original image
	 	// @see	http://us.php.net/manual/en/function.imagecopymerge.php#32393
	 	//---------------------------------------------------------

		/* PNGs like to be difficult: Bug #20788 */
		if( $type == 'png' )
		{
			/* Create a new image */
			$new_img = imagecreatetruecolor( $this->currentDeminsions['width'], $this->currentDeminsions['height'] );

			/* Setup Transparency */
			imagealphablending( $new_img, false );
			$transparent = imagecolorallocatealpha( $new_img, 0, 0, 0, 127 );
			imagefill( $new_img, 0, 0, $transparent );
			imagesavealpha( $new_img, true );
			imagealphablending( $new_img, true );

			/* Copy the main image into the new image */
			imagecopyresampled( $new_img, $this->image, 0, 0, 0, 0, $this->currentDeminsions['width'], $this->currentDeminsions['height'], $this->currentDeminsions['width'], $this->currentDeminsions['height'] );

			/* Copy the watermark onto the new image */
		 	imagecopyresampled( $new_img, $mark, $watermarkPositionX, $watermarkPositionY, 0, 0, $img_info[0], $img_info[1], $img_info[0], $img_info[1] );

			/* Set the image */
			$this->image = $new_img;
		}
		else
		{
			@imagecopymerge( $this->image, $mark, $watermarkPositionX, $watermarkPositionY, 0, 0, $img_info[0], $img_info[1], $opacity );
		}


	 	//---------------------------------------------------------
	 	// And alpha blending again...
	 	//---------------------------------------------------------

		switch( $this->imageExtension )
		{
			case 'png':
				@imagealphablending( $this->image, FALSE );
				@imagesavealpha( $this->image, TRUE );
			break;
		}

	 	//---------------------------------------------------------
	 	// Destroy watermark image resource and return
	 	//---------------------------------------------------------

	 	imagedestroy( $mark );

	 	return true;
	}
}

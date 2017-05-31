<?php
 /**
  * @author rest7.com
  * @license MIT
  * @version 0.1
  * @link http://github.com/rest7/api Documentation
  */
  
function _uploadFile7($url, &$fileBody, $fileName)
{
	$boundary = '--------------------------' . microtime(1);
	$head = "Content-Type: multipart/form-data; boundary=$boundary";
	$content =  "--$boundary\r\n".
	            'Content-Disposition: form-data; name="file"; filename="' . $fileName . '"' . "\r\n" .
	            "Content-Type: application/zip\r\n\r\n".
	            "$fileBody\r\n";
	$content .= "--$boundary--\r\n";
	
	$context = stream_context_create(array(
		'http' => array(
			'method' => 'POST',
			'header' => $head,
			'content' => $content,
		)
	));
	$res = @file_get_contents($url, false, $context);
	return $res;
}

function _loadImage7($inputImage, &$imageBody, &$imageName, &$imageUrl)
{
	$res = get_resource_type($inputImage);
	if ($res == 'gd')
	{
		ob_start();
		imagepng($inputImage, NULL, 1, PNG_NO_FILTER);
		$imageBody = ob_get_contents();
		$imageName = 'image.png';
		$imageUrl = false;
		ob_end_clean();
		return true;
	}
	if (is_file($inputImage))
	{
		$imageBody = file_get_contents($inputImage);
		$imageName = basename($image);
		$imageUrl = false;
		return true;
	}
	if (substr($inputImage, 0, 4) == 'http')
	{
		$imageName = $imageBody = false;
		$imageUrl = $inputImage;
		return true;
	}
	return false;	
}

 /**
   * Checks if an image was upscaled
   *
   * @param  mixed $image  Image resource, filename or URL
   *
   * @return int 1, if image was upscaled, 0 if not upscaled, false when error occured
   *
   */
function imageUpscaled7($image)
{
	if (!_loadImage7($image, $imageBody, $imageName, $imageUrl)) return false;
	
	if ($imageUrl)
	{
		$res = @file_get_contents('http://api.rest7.com/v1/image_upscaled.php?url=' . $imageUrl);
	}
	else
	{
		$res = _uploadFile7('http://api.rest7.com/v1/image_upscaled.php', $imageBody, $imageName);
		unset($imageBody);
	}
	$data = json_decode($res);
	
	if (@$data->success !== 1)
	{
		return false;
	}

	return ($data->is_upscaled) ? 1 : 0;
}

 /**
   * Converts an image to a different format
   *
   * @param  mixed $image  Image resource, filename or URL
   * @param  string $outputFormat  Output format extension, eg. png, jpg, gif
   * @param  bool $returnURL  True returns an URL to the image, False returns the image as string
   *
   * @return bool true, if image was converted, false when error occured
   *
   */
function convertImage7($image, $outputFormat = 'png', $returnURL = false)
{
	if (!_loadImage7($image, $imageBody, $imageName, $imageUrl)) return false;
	
	if ($imageUrl)
	{
		$res = @file_get_contents('http://api.rest7.com/v1/image_convert.php?format=' . $outputFormat . '&url=' . $imageUrl);
	}
	else
	{
		$res = _uploadFile7('http://api.rest7.com/v1/image_convert.php?format=' . $outputFormat, $imageBody, $imageName);
		unset($imageBody);
	}
	$data = json_decode($res);
	
	if (@$data->success !== 1)
	{
		return false;
	}
	
	if ($returnURL)
	{
		return $data->file;
	}
	
	$res = @file_get_contents($data->file);
	if (strlen($res)<10)
	{
		return false;
	}	
	return $res;
}
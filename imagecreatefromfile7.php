<?php
 /**
  * @author rest7.com
  * @license MIT
  * @version 0.1
  * @link http://github.com/rest7/api Documentation
  */  

function imagecreatefromcin($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefromsct($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefrompix($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefrommtv($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefromjbg($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefromdpx($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefromdcx($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefromrla($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefromfts($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefromtga($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefrompbm($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefrompnm($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefromppm($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefrompgm($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefrompcx($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefrombmp($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefromico($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefrompsd($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefromdds($fileName)
{
	return imagecreatefromfile7($fileName);
}

function imagecreatefromfile7($fileName)
{
	$boundary = '--------------------------' . microtime(1);
	$head = "Content-Type: multipart/form-data; boundary=$boundary";
	$content =  "--$boundary\r\n".
	            'Content-Disposition: form-data; name="file"; filename="' . $fileName . '"' . "\r\n" .
	            "Content-Type: application/octet-stream\r\n\r\n".
	            file_get_contents($fileName) . "\r\n";
	$content .= "--$boundary--\r\n";	
	$context = stream_context_create(array(
		'http' => array(
			'method' => 'POST',
			'header' => $head,
			'content' => $content,
		)
	));
	$data = json_decode(@file_get_contents('http://api.rest7.com/v1/image_convert.php?format=png', false, $context));
	if (@$data->success !== 1)
	{
		return false;
	}
	$im = imagecreatefromstring(file_get_contents($data->file));
	return $im;
}
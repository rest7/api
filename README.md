REST7 API
=========
Collection of free web services. No registration required. Wizards available at:

 - http://rest7.com/

How to use the webservices?
------------
There's two possibilities:
- check the wizards at rest7.com and generate simple code pieces you need
- download the library from this repository

Using a webservice
-----------------

You can use a webservice from PHP just like that:
```php
//lets convert image from JPEG to PNG using "image_convert"
$url = 'http://api.rest7.com/v1/image_convert.php?url=http://server.com/image.jpg';

//call API method
$data = json_decode(file_get_contents($url));

//fetch converted image
$image = file_get_contents($data->image);

//save fetched image to disk
file_put_contents('output.png', $image); 
```
Or you can use a very simple PHP library
-----------------
Example 1: converting image from PNG to DDS
```php
include 'rest7.php';

//load an image from file:
$im = imagecreatefrompng('test.png'); //using a resource, or:
$im = 'http://server.com/dir/test.png'; //using an URL or:
$im = 'dir/test.png'; //using a local file

//convert to DDS
$dds = convertImage7($im, 'dds');

if (!$dds)
{
	echo 'Conversion failed';
}
else
{
	//save to file
	file_put_contents('output.dds', $dds);
}
```
Example 2: checking if image was upscaled
```php
include 'rest7.php';

//load an image from file:
$im = imagecreatefrompng('test.png'); //using a resource, or:
$im = 'http://server.com/dir/test.png'; //using an URL or:
$im = 'dir/test.png'; //using a local file

$res = imageUpscaled7($im);
if ($res === false)
{
	echo 'Function failed';
}
else if ($res)
{
	echo 'Image was upscaled';
}
else
{
	echo 'Image was not upscaled';
}
```

Available API webservices
-----------------
Image:
- image_convert (convert an image from one format to another, eg. convert from PNG to GIF)
- image_filter (apply a filter to an image, eg. make it grayscale)
- image_upscaled (checks if an image was upscaled)
- png_lossless (losslessy converts a PNG image into a smaller PNG)
- png_lossy (convert a PNG image into a smaller PNG using lossy compression)
- jpeg_optim (removes all metadata from JPEG images, including thumbnails and EXIF)
- gif_lossy  (convert a GIF image into a smaller GIF using lossy compression)
- raster_to_vector (converts a raster image into a vector image, eg. PNG-->SVG)
- visual_hash (calculates visual hash of an image; visual hashes can be used to compare images visually)

Currency:
- currency_convert (converts various amounts of money between currencies, eg. EUR-->USD)

File:
- file_hash (calculates hash and checksum values, eg. MD5, CRC32)

Text:
- text_transform (transforms text, eg. makes text uppercase)
- text_hash  (calculates hash and checksum values, eg. MD5, CRC32)

HTML:
- html_to_image (converts HTML document into an image)
- html_to_text (converts HTML document into text)
- html_to_pdf  (converts HTML document into PDF)

Wikipedia:
- wikipedia_search (finds articles)
- wikipedia_page (returns a wikipedia article in HTML or plaintext format)

PDF:
- pdf_images (extracts images from a PDF document)
- pdf_info (returns information about a PDF document, including used fonts)
- pdf_split (extracts a single page from a PDF document)
- pdf_to_html (converts a PDF document to an HTML page)
- pdf_to_image (converts a PDF document into an image)
- pdf_to_text (converts a PDF document into plaintext)

Available PHP classes & methods
-----------------
Not all API methods are available as PHP classes.

Currently available are:
- imageUpscaled7($image)
- convertImage7($image, $outputFormat = 'png', $returnURL = false)
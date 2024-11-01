### WHAT

A library used to read and write `textboxes` in a flat XML opendocument file. 

File extensions which can be used are

* fodt - Flat XML ODT Text Document
* fodg - Flat XML ODF Drawing Document

### USAGE

~~~~
<?php
//initialization

$dom = new \OA\OpenDocument\FlatXML\DOM;

$filename = __DIR__ . '/input.fodt';

$dom->loadXMLFile($filename);



//Extract fields from the document

$fields = $dom->extractFields();


//write fields

$dom->overwriteFields(array(

	"field name" => "value",
));
~~~~


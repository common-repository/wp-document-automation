<?php

use OA\OpenDocument\FlatXML\DOM;
use PHPUnit\Framework\TestCase;

class DomTest extends TestCase {

	public function _testExtractFields() {
		$expectedFields = array(
			"authorized person name",
			"designation",
			"email",
			"softex number",
			"period of softex unwanted paragraph",
			"name of unit",
			"registration upto",
			"period",
			"softexno",
			"address",
		);

		$dom = $this->getDom();
		$fields = $dom->extractFields();

		sort($expectedFields);
		sort($fields);

		$this->assertEquals($expectedFields, $fields);
	}

	public function _testOverwriteFields() {
		$fields = array(
			"authorized person name" => 'Charlie Munger',
			"designation" => 'Vice President',
			"email" => 'charlie@berkshirehathaway.com',
			"softex number" => 'CHR-WRRN-2332',
			"period of softex unwanted paragraph" => 'Nov 2010',
			"name of unit" => 'Berkshire Hathaway',
			"registration upto" => '18/03/2022',
			'address' => 'BERKSHIRE HATHAWAY INC, 3555 Farnam Street,Omaha, NE 68131',
		);

		$dom = $this->getDom();
		$dom->overwriteFields($fields);
		$output = $dom->saveXML();
		$expectedOutput = file_get_contents(__DIR__ . '/expected-output.fodt');

		$this->assertEquals($expectedOutput, $output, 'FODT file output did not match.');

		// file_put_contents('output.fodt', $output);
	}

	public function testUserDefinedFields() {
		$fields = array(
			'name' => 'Bill Gates',
			'address' => 'BERKSHIRE HATHAWAY INC, 3555 Farnam Street,Omaha, NE 68131',
		);

		$dom = $this->getDom('resume.fodt');
		$dom->overwriteFields($fields);
		$output = $dom->saveXML();

		// echo $output;
		$expectedOutput = file_get_contents(__DIR__ . '/expected-resume.fodt');

		// file_put_contents('o.fodt', $output);
		$this->assertEquals($expectedOutput, $output, 'FODT file output did not match.');

	}

	protected function getDom($file = 'input.fodt') {
		$dom = new DOM;
		$filename = __DIR__ . '/' . $file;
		return $dom->loadXMLFile($filename);
	}

}

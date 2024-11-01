<?php
namespace OA\OpenDocument\FlatXML;
use Exception;

class DOM extends \DOMDocument {
	protected $textBoxFields = array();

	public function loadXMLFile($filename) {
		$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

		if (!file_exists($filename)) {
			throw new Exception("File not found", 404);
		}

		if (!in_array($extension, array('fodt', 'fodg'))) {
			throw new Exception("File type not supported", 404);
		}

		$xml = file_get_contents($filename);
		$this->loadXML($xml);
		$this->preserveWhiteSpace = false;

		return $this;
	}

	public function extractFields() {
		$fields = array();

		$textBoxes = $this->getElementsByTagName('text-box');
		foreach ($textBoxes as $textBox) {
			$fields[] = $this->getTextBoxValue($textBox);
		}

		$userfields = $this->getElementsByTagName('user-field-decl');

		foreach ($userfields as $userfield) {
			$fields[] = $userfield->getAttribute('text:name');
		}

		return array_unique($fields);
	}

	public function setField($name, $value) {
		$this->textBoxFields[$name] = $value;
	}

	public function setFields($keyValuePairs) {
		foreach ($keyValuePairs as $key => $value) {
			$this->setField($key, $value);
		}
	}

	public function overwriteFields($fields = array()) {
		$this->setFields($fields);

		// text boxes
		$textBoxes = $this->getElementsByTagName('text-box');

		foreach ($textBoxes as $textBoxIter => $textBox) {
			$fieldName = $this->getTextBoxValue($textBox);
			//$this->debug("Text Box : {$fieldName}");

			if (isset($this->textBoxFields[$fieldName])) {
				$paras = $textBox->getElementsByTagName('p');

				$count = $paras->length;
				//$this->debug("\t\tPara Count {$paras->length}");

				if (!$count) {
					continue;
				}

				// remove extra paras
				if ($count > 1) {
					for ($i = 1; $i < $count; $i++) {
						$textBox->removeChild($paras[$i]);
					}
				}

				$para = $paras[0];
				//$this->debug("Para = {$para->nodeValue}");
				$replacement = $this->textBoxFields[$fieldName];

				$spans = $para->getElementsByTagName('span');

				$spanCount = $spans->length;
				//$this->debug("Span Count . " . (string) $spanCount);

				if ($spanCount === 0) {
					//$this->debug("Direct Para = {$para->nodeValue}");
					$spanNode = $this->createElement("text:span");
					$spanNode->nodeValue = $replacement;
					$para->nodeValue = '';
					$para->appendChild($spanNode);
				} else {
					// //$this->debug("Span = {$spans[0]->nodeValue}");
					// var_dump($textBoxes[$textBoxIter]->paras[0]->spans[0]);
					// var_dump($spans);
					$spans[0]->nodeValue = $replacement;
					if ($spanCount > 1) {
						for ($i = 1; $i < $spanCount; $i++) {
							$para->removeChild($spans[$i]);
						}
					}
				}
			}

		} //foreach

		// user fields
		$userfields = $this->getElementsByTagName('user-field-decl');
		foreach ($userfields as $userfield) {
			$fieldName = $userfield->getAttribute('text:name');

			// $this->debug("{$fieldName}");
			if (isset($this->textBoxFields[$fieldName])) {
				$valueType = $userfield->getAttribute('office:value-type');
				$userfield->setAttribute("office:{$valueType}-value", $this->textBoxFields[$fieldName]);
			}
		}

	}

	protected function getTextBoxValue($textBox) {
		$values = explode("\n", trim($textBox->nodeValue));
		$values = array_map('trim', $values);
		return strtolower(implode(' ', $values));
	}

	public function debug($message) {
		echo "\n$message\n";
	}
}

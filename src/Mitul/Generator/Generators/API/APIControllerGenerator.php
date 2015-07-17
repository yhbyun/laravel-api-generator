<?php

namespace Mitul\Generator\Generators\API;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;
use Mitul\Generator\Utils\GeneratorUtils;

class APIControllerGenerator implements GeneratorProvider
{
	/** @var  CommandData */
	private $commandData;

	/** @var string  */
	private $path;

	function __construct($commandData)
	{
		$this->commandData = $commandData;
		$this->path = Config::get('generator.path_api_controller', base_path('app/Http/Controllers/API/'));
	}

	public function generate()
	{
		$templateData = $this->commandData->templatesHelper->getTemplate("Controller", "api");

		$templateData = $this->fillTemplate($templateData);

		$fileName = $this->commandData->modelNamePlural . "Controller.php";

		if(!file_exists($this->path))
			mkdir($this->path, 0755, true);

		$path = $this->path . $fileName;

		$this->commandData->fileHelper->writeFile($path, $templateData);
		$this->commandData->commandObj->comment("\nAPI Controller created: ");
		$this->commandData->commandObj->info($fileName);
	}

	private function fillTemplate($templateData)
	{
		$templateData = GeneratorUtils::fillTemplate($this->commandData->dynamicVars, $templateData);

		$fillables = [];

		foreach($this->commandData->inputFields as $field)
		{
			$fieldName = $field['fieldName'];
			if ($fieldName !== 'RegDate' && $fieldName !== 'ModDate') {
				$fillables[] = '\'' . $field['fieldName'] . '\'';
			}
		}

		$tab = $this->commandData->tab;

		$templateData = str_replace('$FIELDS$', implode(", ", $fillables), $templateData);

		$templateData = str_replace('$RULES$', implode(",\n" . $tab . $tab . $tab, $this->generateRules()), $templateData);

		return $templateData;
	}

	private function generateRules()
	{
		$rules = [];

		foreach($this->commandData->inputFields as $field)
		{
			switch($field['fieldType'])
			{
				case 'integer':
					$rule = '\'' . $field['fieldName'] . '\' => \'required:integer\'';
					break;
				case 'double':
				case 'float':
					$rule = '\'' . $field['fieldName'] . '\' => \'required:numeric\'';
					break;
				case 'string':
				case 'char':
				case 'text':
					$rule = '\'' . $field['fieldName'] . '\' => \'required\'';
					break;
				default:
					$rule = '';
					break;
			}

			if (!empty($rule)) {
				$rules[] = $rule;
			}
		}

		return $rules;
	}
}

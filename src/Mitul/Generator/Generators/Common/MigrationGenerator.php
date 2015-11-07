<?php

namespace Mitul\Generator\Generators\Common;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;
use Mitul\Generator\SchemaGenerator;
use Mitul\Generator\Utils\GeneratorUtils;

class MigrationGenerator implements GeneratorProvider
{
	/** @var  CommandData */
	private $commandData;

	/** @var string */
	private $path;

	function __construct($commandData)
	{
		$this->commandData = $commandData;
		$this->path = Config::get('generator.path_migration', base_path('database/migrations/'));
	}

	public function generate()
	{
		$templateData = $this->commandData->templatesHelper->getTemplate("Migration", "common");

		$templateData = GeneratorUtils::fillTemplate($this->commandData->dynamicVars, $templateData);

		$templateData = str_replace('$FIELDS$', $this->generateFieldsStr(), $templateData);

		$fileName = date('Y_m_d_His') . "_" . "create_" . $this->commandData->modelNamePluralSnake . "_table.php";

		$path = $this->path . $fileName;

		$this->commandData->fileHelper->writeFile($path, $templateData);
		$this->commandData->commandObj->comment("\nMigration created: ");
		$this->commandData->commandObj->info($fileName);
	}

	private function generateFieldsStr()
	{
		$naming = Config::get('generator.schema_field_naming', 'snake');

		$tab = $this->commandData->tab;

		$pkField = $naming === 'snake' ? 'id' : 'ID';
		$fieldsStr = "\$table->increments('{$pkField}');\n";

		foreach($this->commandData->inputFields as $field)
		{
			$fieldsStr .= SchemaGenerator::createField($field['fieldInput']);
		}

		$fieldsStr .= $tab . $tab . $tab . "\$table->timestamps();";

		if($this->commandData->useSoftDelete)
			$fieldsStr .= $tab . $tab . $tab . "\n\$table->softDeletes();";

		return $fieldsStr;
	}
}

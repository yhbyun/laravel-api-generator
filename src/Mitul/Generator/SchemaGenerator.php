<?php

namespace Mitul\Generator;

use Config;

class SchemaGenerator
{
	public static function createField($field)
	{
		$fieldInputs = explode(':', $field);

		$fieldName = array_shift($fieldInputs);

		$fieldTypeInputs = array_shift($fieldInputs);

		$fieldTypeInputs = explode(",", $fieldTypeInputs);

		$fieldType = array_shift($fieldTypeInputs);

		$tab = Config::get('generator.tab', "\t");
		$fieldStr = $tab . $tab . $tab . "\$table->" . $fieldType . "('" . $fieldName . "'";

		if(sizeof($fieldTypeInputs) > 0)
		{
			foreach($fieldTypeInputs as $param)
			{
				$fieldStr .= ", " . $param;
			}
		}

		$fieldStr .= ")";

		if(sizeof($fieldInputs) > 0)
		{
			foreach($fieldInputs as $input)
			{
				$input = explode(",", $input);

				$option = array_shift($input);

				$fieldStr .= '->' . $option . '(';

				if(sizeof($input) > 0)
				{
					foreach($input as $param)
					{
						$fieldStr .= "'" . $param . "', ";
					}

					$fieldStr = substr($fieldStr, 0, strlen($fieldStr) - 2);
				}

				$fieldStr .= ")";
			}
		}

		if(!empty($fieldStr))
			$fieldStr .= ";\n";

		return $fieldStr;
	}
}

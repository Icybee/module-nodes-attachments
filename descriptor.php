<?php

namespace Icybee\Modules\Nodes\Attachments;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\Module;

return array
(
	Module::T_CATEGORY => 'features',
	Module::T_DESCRIPTION => "Allows files to be attached to nodes.",
	Module::T_MODELS => array
	(
		'primary' => array
		(
			Model::CLASSNAME => 'ICanBoogie\ActiveRecord\Model',
			Model::ACTIVERECORD_CLASS => 'ICanBoogie\ActiveRecord',
			Model::SCHEMA => array
			(
				'fields' => array
				(
					'nodeid' => array('foreign', 'primary' => true),
					'fileid' => array('foreign', 'primary' => true),
					'title' => 'varchar',
					'weight' => array('integer', 'tiny', 'unsigned' => true)
				)
			)
		)
	),

	Module::T_REQUIRES => array
	(
		'nodes' => '1.0'
	),

	Module::T_NAMESPACE => __NAMESPACE__,
	Module::T_TITLE => 'Attachments'
);
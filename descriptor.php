<?php

namespace Icybee\Modules\Nodes\Attachments;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\Module\Descriptor;

return array
(
	Descriptor::CATEGORY => 'features',
	Descriptor::DESCRIPTION => "Allows files to be attached to nodes.",
	Descriptor::MODELS => array
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

	Descriptor::REQUIRES => array
	(
		'nodes' => '1.0'
	),

	Descriptor::NS => __NAMESPACE__,
	Descriptor::TITLE => 'Attachments'
);
<?php

namespace Icybee\Modules\Nodes\Attachments;

use ICanBoogie\ActiveRecord\Model;
use ICanBoogie\Module\Descriptor;

return [

	Descriptor::CATEGORY => 'features',
	Descriptor::DESCRIPTION => "Allows files to be attached to nodes.",
	Descriptor::MODELS => [

		'primary' => [

			Model::CLASSNAME => 'ICanBoogie\ActiveRecord\Model',
			Model::ACTIVERECORD_CLASS => 'ICanBoogie\ActiveRecord',
			Model::SCHEMA => [

				'nodeid' => [ 'foreign', 'primary' => true ],
				'fileid' => [ 'foreign', 'primary' => true ],
				'title' => 'varchar',
				'weight' => [ 'integer', 'tiny', 'unsigned' => true ]

			]
		]
	],

	Descriptor::REQUIRES => [ 'nodes' ],
	Descriptor::NS => __NAMESPACE__,
	Descriptor::TITLE => 'Attachments'

];

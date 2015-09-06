<?php

namespace Icybee\Modules\Nodes\Attachments;

$hooks = Hooks::class . '::';

return [

	'patron.markups' => [

		'node:attachments' => [

			$hooks . 'markup_node_attachments'

		]

	]

];

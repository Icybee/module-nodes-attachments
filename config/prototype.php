<?php

namespace Icybee\Modules\Nodes\Attachments;

use Icybee;

$hooks = Hooks::class . '::';

return [

	Icybee\Modules\Nodes\Node::class . '::lazy_get_attachments' => $hooks . 'lazy_get_attachments'

];

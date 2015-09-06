<?php

namespace Icybee\Modules\Nodes\Attachments;

use Icybee;

$hooks = Hooks::class . '::';

return [

	Icybee\Modules\Files\Block\ConfigBlock::class . '::alter_children' => $hooks . 'on_files_configblock_alter_children',
	Icybee\Modules\Files\Operation\ConfigOperation::class . '::properties:before' => $hooks . 'before_config_operation_properties',
	Icybee\Modules\Files\Operation\DeleteOperation::class . '::process' => $hooks . 'on_file_delete',
	Icybee\Modules\Nodes\Operation\DeleteOperation::class . '::process' => $hooks . 'on_node_delete',
	Icybee\Modules\Nodes\Block\EditBlock::class . '::alter_children' => $hooks . 'on_editblock_alter_children',
	Icybee\Modules\Nodes\Operation\SaveOperation::class . '::process' => $hooks . 'on_node_save'

];

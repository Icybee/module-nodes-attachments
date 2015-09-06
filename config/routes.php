<?php

namespace Icybee\Modules\Nodes\Attachments;

use Icybee\Routing\RouteMaker as Make;

return Make::admin('nodes.attachments', Routing\AttachmentAdminController::class, [

	'only' => 'config'

]);

<?php

/*
 * This file is part of the Icybee package.
 *
 * (c) Olivier Laviale <olivier.laviale@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Icybee\Modules\Nodes\Attachments\Element;

use ICanBoogie\I18n;
use ICanBoogie\Operation;

use Brickrouge\Element;
use Brickrouge\Document;

use Icybee\Binding\Core\PrototypedBindings;

class AttachmentsElement extends Element
{
	use PrototypedBindings;

	const T_NODEID = '#attachments-nodeid';
	const T_HARD_BOND = '#attachments-hard-bond';

	static protected function add_assets(Document $document)
	{
		parent::add_assets($document);

		$document->css->add(__DIR__ . '/AttachmentsElement.css');
		$document->js->add(__DIR__ . '/AttachmentsElement.js');
	}

	public function __construct(array $attributes = [])
	{
		parent::__construct('div', $attributes + [

			Element::IS => 'NodeAttachments'

		]);

		$this->add_class('widget-node-attachments');
		$this->add_class('resources-files-attached');
	}

	protected function render_inner_html()
	{
		$nid = $this[self::T_NODEID];
		$hard_bond = $this[self::T_HARD_BOND] ?: false;

		$lines = null;

		if ($nid)
		{
			$records = $this->app->models['nodes.attachments']->query
			(
				'SELECT {alias}.*, file.nid, file.size, file.extension
				FROM {self} {alias}
				INNER JOIN {prefix}files file ON {alias}.fileid = file.nid
				WHERE nodeid = ?', [ $nid ]
			)
			->all(\PDO::FETCH_OBJ);

			foreach ($records as $record)
			{
				$lines .= self::create_attachment($record, $hard_bond);
			}
		}

		$formats = null;

		//$formats = 'Seules les pièces avec les extensions suivantes sont prises en charge&nbsp;: jpg jpeg gif png txt doc xls pdf ppt pps odt ods odp.';

		$limit = ini_get('upload_max_filesize') * 1024 * 1024;
		$limit_formated = \ICanBoogie\I18n\format_size($limit);

		$label_join = $this->t('Add a new attachment');
		$label_limit = $this->t('The maximum size for each attachment is :size', [ ':size' => $limit_formated ]);

		$label_join = new \Brickrouge\File([

			\Brickrouge\File::FILE_WITH_LIMIT => $limit / 1024,
			\Brickrouge\File::T_UPLOAD_URL => '/api/nodes.attachments/upload'

		]);

		return <<<EOT
<ol>
	$lines
	<li class="progress">&nbsp;</li>
</ol>

$label_join

<!--div class="element-description">$label_limit.$formats</div-->
EOT;
	}

	static public function create_attachment($record, $hard_bond=false) // TODO-20120922: create an Element class instead
	{
		$hiddens = null;
		$links = [];

		$i = uniqid();
		$size = \ICanBoogie\I18n\format_size($record->size);
		$preview = null;

		if ($record instanceof Uploaded)
		{
			$title = $record->name;
			$extension = $record->extension;

			$hiddens .= '<input type="hidden" class="file" name="nodes_attachments[' . $i .'][file]" value="' . \ICanBoogie\escape(basename($record->location)) . '" />' . PHP_EOL;
			$hiddens .= '<input type="hidden" name="nodes_attachments[' . $i .'][mime]" value="' . \ICanBoogie\escape($record->mime) . '" />' . PHP_EOL;

			$links = [

				'<a href="#remove" class="btn btn-warning">' . I18n\t('label.remove') . '</a>'

			];
		}
		else
		{
			$fid = $record->nid;
			$title = $record->title;
			$extension = $record->extension;

			$hiddens .= '<input type="hidden" name="nodes_attachments[' . $i .'][fileid]" value="' . $fid . '" />';

			$links = [

				'<a href="' . \ICanBoogie\app()->url_for('admin:files:edit', $record) . '" class="btn"><i class="icon-pencil"></i> ' . I18n\t('label.edit') .'</a>',
				'<a href="' . Operation::encode('files/' . $fid . '/download') . '" class="btn"><i class="icon-download-alt"></i> ' . I18n\t('label.download') . '</a>',
				$hard_bond ? '<a href="#delete" class="btn btn-danger"><i class="icon-remove icon-white"></i> ' . I18n\t('Delete file') .'</a>' : '<a href="#remove" class="btn btn-warning"><i class="icon-remove"></i> ' . t('Break link') . '</a>'

			];

			$node = \ICanBoogie\app()->models['nodes'][$record->nid];

			if ($node instanceof \Icybee\Modules\Images\Image)
			{
				$preview = $node->thumbnail('$icon')->to_element([

					'data-popover-image' => $node->thumbnail('$popover')->url

				]);
			}
		}

		$title = \ICanBoogie\escape($title);
		$links = empty($links) ? '' : (' &ndash; ' . implode(' ', $links));

		if ($extension)
		{
			$extension = '<span class="lighter">(' . $extension . ')</span>';
		}

		return <<<EOT
<li>
	<span class="handle">↕</span>$preview<input type="text" name="nodes_attachments[$i][title]" value="$title" />
	<span class="small">
		<span class="info light">$size $extension</span> $links
	</span>

	$hiddens
</li>
EOT;
	}
}

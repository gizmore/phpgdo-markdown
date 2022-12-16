<?php
namespace GDO\Markdown;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Message;
use GDO\Core\GDT_Checkbox;
use GDO\Language\Trans;
use GDO\HTML\Module_HTML;

/**
 * Markdown editor for gdo6.
 * Uses markdown from 
 * 
 * @author gizmore
 * @version 7.0.2
 * @since 6.10.5
 */
final class Module_Markdown extends GDO_Module
{
	
	public int $priority = 45;
	public string $license = 'MIT';
	
	public function getDependencies(): array
	{
		return [
			'HTML',
			'JQuery',
			'FontAwesome',
		];
	}
	
	public function getLicenseFilenames(): array
	{
		return [
			'markdown/LICENSE',
			'bower_components/editor.md/LICENSE',
			'bower_components/editor.md/lib/codemirror/LICENSE',
			'LICENSE',
		];
	}
	
	public function thirdPartyFolders(): array
	{
		return [
			'bower_components/',
			'markdown/',
		];
	}
	
	public function getConfig(): array
	{
		return [
			GDT_Checkbox::make('markdown_js_editor')->initial('1'),
		];
	}
	public function cfgJSEditor() { return $this->getConfigVar('markdown_js_editor'); }
	
	public function onModuleInit()
	{
		GDT_Message::addDecoder('Markdown', [self::class, 'DECODE']);
	}
	
	public static function DECODE(string $s): string
	{
		$s = Decoder::decoded($s);
		return Module_HTML::instance()->purify($s);
	}
	
	public function onIncludeScripts() : void
	{
		$min = $this->cfgMinAppend();
		if ($this->cfgJSEditor())
		{
			$this->addBowerJS("editor.md/editormd{$min}.js");
			$this->addJS('js/gdo-markdown.js');
			$this->addCSS("css/editormd.css");
		}
		$this->addCSS('css/gdo-markdown.css');
		
		# Load language pack
		if ($this->cfgJSEditor())
		{
			switch (Trans::$ISO)
			{
				case 'de':
					$this->addJS('js/editor.md_de.js');
					break;
				default:
					$this->addBowerJS("editor.md/languages/en.js");
					break;
			}
		}
	}
	
}

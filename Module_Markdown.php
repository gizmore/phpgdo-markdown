<?php
namespace GDO\Markdown;

use GDO\Core\GDO_Module;
use GDO\Core\GDT_Array;
use GDO\UI\GDT_Message;
use GDO\Util\Strings;
use GDO\Core\GDT_Checkbox;
use GDO\Language\Trans;

/**
 * Markdown editor for gdo6.
 * Uses markdown from 
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 6.10.5
 */
final class Module_Markdown extends GDO_Module
{
	public int $priority = 45;
	public string $license = 'MIT';
	
	public function getDependencies() : array
	{
		return [
			'JQuery',
			'FontAwesome',
		];
	}
	
	public function getLicenseFilenames() : array
	{
		return [
			'markdown/LICENSE',
			'bower_components/editor.md/LICENSE',
			'bower_components/editor.md/lib/codemirror/LICENSE',
			'LICENSE',
		];
	}
	
	public function getConfig() : array
	{
		return [
			GDT_Checkbox::make('markdown_decoder')->initial('1'),
			GDT_Checkbox::make('markdown_js_editor')->initial('1'),
		];
	}
	public function cfgDecoder() { return $this->getConfigVar('markdown_decoder'); }
	public function cfgJSEditor() { return $this->getConfigVar('markdown_js_editor'); }
	
	public function onModuleInit()
	{
		if ($this->cfgDecoder())
		{
			GDT_Message::$DECODERS['Markdown'] =
			GDT_Message::$DECODER = [self::class, 'decode'];
			GDT_Message::$EDITOR_NAME = 'Markdown';
			spl_autoload_register([$this, 'autoloadMarkdown']);
		}
	}

	public static function decode($input)
	{
		$html = (new Decoder($input))->decoded();
		$html = trim($html);
		return GDT_Message::getPurifier()->purify($html);
	}
	
	public function autoloadMarkdown($class)
	{
		if (str_starts_with($class, 'cebe\\markdown\\'))
		{
			$class = Strings::substrFrom($class, 'cebe\\markdown\\');
			$class = str_replace('\\', '/', $class) . '.php';
			$class = $this->filePath('markdown/'.$class);
			require_once $class;
		}
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
	
	public function hookIgnoreDocsFiles(GDT_Array $ignore)
	{
		$ignore->data[] = 'GDO/Markdown/markdown/**/*';
	}
	
}

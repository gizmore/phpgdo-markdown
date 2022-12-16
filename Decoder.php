<?php
namespace GDO\Markdown;

use GDO\Util\Strings;
use cebe\markdown\GithubMarkdown;

/**
 * Decode Markdown into HTML.
 * 
 * @author gizmore
 * @since 7.0.2
 */
final class Decoder
{
	
	/**
	 * On init register the autoloader.
	 * Init is only called when there needs to be markdown decoded. zero cost!
	 */
	public static function init(): void
	{
		spl_autoload_register([self::class, 'autoloadMarkdown'], true);
	}
	
    public static function autoloadMarkdown(string $class)
    {
    	if (str_starts_with($class, 'cebe\\markdown\\'))
    	{
    		$class = Strings::substrFrom($class, 'cebe\\markdown\\');
    		$class = str_replace('\\', '/', $class) . '.php';
    		$class = Module_Markdown::instance()->filePath('markdown/'.$class);
    		require_once $class;
    	}
    }
    
    public static function decoded(string $s): string
    {
    	static $PARSER = new GithubMarkdown();
    	return $PARSER->parse($s);
    }
    
}

Decoder::init();

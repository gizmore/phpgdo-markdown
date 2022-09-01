<?php
namespace GDO\Markdown\Test;

use GDO\Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use GDO\Markdown\Module_Markdown;

final class MarkdownTest extends TestCase
{
    public function testHTMLEscape()
    {
        $input = '<hi>';
        $decoded = Module_Markdown::decode($input);
        assertEquals('', $decoded, 'Test if input validation works for Markdown renderer.');
    }
    
    public function testMarkdown()
    {
    	$input = '# Hello';
    	$decoded = Module_Markdown::decode($input);
    	assertEquals('<h1>Hello</h1>', $decoded, 'Test roughly if Markdown decoding works.');
    }
    
}

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
        assertEquals('&lt;hi&gt;', $decoded, 'Test if input validation works for Markdown renderer.');
    }
    
}

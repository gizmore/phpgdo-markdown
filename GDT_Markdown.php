<?php
declare(strict_types=1);
namespace GDO\Markdown;

use GDO\Core\GDT;
use GDO\Core\WithValue;

/**
 * Markdown source as var and its purified HTML rendering as value.
 */
final class GDT_Markdown extends GDT
{

	use WithValue;

	public function toValue(null|string|array $var): null|bool|int|float|string|object|array
	{
		return $var === null ? null : Module_Markdown::DECODE($var);
	}

	public function renderHTML(): string
	{
		return $this->getValue() ?? self::EMPTY_STRING;
	}

	public function renderCard(): string
	{
		return '<div class="gdt-markdown">' . $this->renderHTML() . '</div>';
	}

	public function renderJSON(): array|string|null|int|bool|float
	{
		return $this->getValue();
	}

	public function renderCLI(): string
	{
		return $this->getVar() ?? self::EMPTY_STRING;
	}

}

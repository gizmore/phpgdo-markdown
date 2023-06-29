<?php

namespace GDO\Markdown\Method;

use GDO\Core\GDT;
use GDO\Core\GDT_String;
use GDO\Core\GDT_Text;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Markdown\Decoder;


/**
 * Convert a markdown string to html.
 *
 * @since 7.0.3
 */
class ToHTML extends \GDO\Form\MethodForm
{

    protected function createForm(GDT_Form $form): void
    {
        $form->addFields(
            GDT_Text::make('markdown')->notNull(),
            GDT_AntiCSRF::make());
        $form->actions()->addField(GDT_Submit::make());
    }

    public static function convert(string $markdown): string
    {
        return Decoder::decoded($markdown);
    }

    public function formValidated(GDT_Form $form): GDT
    {
        $converted = self::convert($form->getFormVar('markdown'));
        return GDT_String::make('result')->initial($converted);
    }

}
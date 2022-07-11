<?php

namespace Marshmallow\ButtonField;

use Laravel\Nova\Fields\Field;

class ButtonField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'button-field';

    public function __construct(...$params)
    {
        parent::__construct(...$params);

        $this->hideWhenCreating()
            ->button()
            ->target('_blank')
            ->setButtonText(
                __('Download')
            );
    }

    public function setButtonText($text)
    {
        $this->withMeta([
            'button' => $text,
        ]);

        return $this;
    }

    public function button()
    {
        return $this->setButtonType('button');
    }

    public function download()
    {
        return $this->setButtonType('download');
    }

    public function target($target)
    {
        $this->withMeta([
            'button_target' => $target,
        ]);

        return $this;
    }

    protected function setButtonType($type)
    {
        $this->withMeta([
            'button_type' => $type,
        ]);

        return $this;
    }
}

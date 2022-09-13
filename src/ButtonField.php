<?php

namespace Marshmallow\ButtonField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

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
            ->available(true)
            ->notAvailableText('n/a')
            ->target('_blank')
            ->fillUsing(function () {
                // Disable updates on the model
            })
            ->setButtonText(
                __('Download')
            );
    }

    public function visibleWhen(callable $callable, string $not_available_text)
    {
        if (!$callable()) {
            $this->available(false)
                ->notAvailableText($not_available_text);
        }
        return $this;
    }

    public function available(bool $available = true)
    {
        $this->withMeta([
            'available' => $available,
        ]);
        return $this;
    }

    public function notAvailableText(string $not_available_text)
    {
        $this->withMeta([
            'not_available_text' => $not_available_text,
        ]);
        return $this;
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

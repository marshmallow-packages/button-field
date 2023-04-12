<?php

namespace Marshmallow\ButtonField;

use Exception;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Marshmallow\ButtonField\Contracts\OnClickInterface;

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
            ->useFieldValue(false)
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

    public function useFieldValue(bool $use_field_value = false)
    {
        $this->withMeta([
            'use_field_value' => $use_field_value,
        ]);
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

    public function text()
    {
        return $this->setButtonType('text');
    }

    public function download(string $download_name = null)
    {
        $this->withMeta([
            'download_name' => $download_name ?? 'download',
        ]);

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

    public function onClick(string $action_class_name)
    {
        if (!new $action_class_name instanceof OnClickInterface) {
            throw new Exception("{$action_class_name} should implement the OnClickInterface interface", 1);
        }

        $this->withMeta([
            'action_class_name' => $action_class_name,
        ]);

        return $this;
    }

    public function icon(string $icon)
    {
        $this->withMeta([
            'icon' => $icon,
        ]);

        return $this;
    }
}

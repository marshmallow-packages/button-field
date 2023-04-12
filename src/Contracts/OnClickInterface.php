<?php

namespace Marshmallow\ButtonField\Contracts;

use Exception;
use Illuminate\Database\Eloquent\Model;

interface OnClickInterface
{
    public function execute(Model $model): void;
    public function success(): string;
    public function error(Exception $exception): string;
}

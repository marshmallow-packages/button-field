<?php

use Laravel\Nova\Nova;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/{resourceName}/{resourceId}', function ($resourceName, $resourceId, Request $request) {

    $resource = Nova::resourceForKey($resourceName);
    $model = $resource::newModel()->findOrFail($resourceId);

    try {
        $action_class = new $request->action_class;
        $action_class->execute($model);
        return [
            'success' => true,
            'message' => $action_class->success(),
        ];
    } catch (Exception $exception) {
        return [
            'success' => false,
            'message' => $action_class->error($exception),
        ];
    }
});

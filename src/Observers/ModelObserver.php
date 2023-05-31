<?php

namespace OnrampLab\CustomFields\Observers;

use Illuminate\Database\Eloquent\Model;

class ModelObserver
{
    public function saving(Model $model): void
    {
        $model->validateCustomFields();
    }

    public function saved(Model $model): void
    {
        $model->saveCustomFieldValues();
    }
}

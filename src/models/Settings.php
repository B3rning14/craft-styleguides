<?php
namespace b3rning14\styleguides\models;

use craft\base\Model;

class Settings extends Model {
    public string $foo = 'defaultFooValue';
    public string $bar = 'defaultBarValue';

    public function rules(): array
    {
        return [
            [['foo', 'bar'], 'required'],
            // ...
        ];
    }
}

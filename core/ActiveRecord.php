<?php

namespace app\core;

/**
 * Class ActiveRecord
 * 
 * @package app\core
 */

abstract class ActiveRecord 
{
    public Validator $validator;

    private array $observers;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->setObservers();
    }

    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public function rules(): array;

    abstract public function observers(): array;

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function save()
    { 
        foreach ($this->observers as $observer) {
            if (method_exists($observer, 'creating')) {
                $observer->creating($this);
            }
        }

        Application::$app->db->save($this);

        foreach ($this->observers as $observer) {
            if (method_exists($observer, 'created')) {
                $observer->created($this);
            }
        }

        return true;
    }

    public function update()
    {
        //
    }

    public function delete()
    {
        //
    }  

    public function validate()
    {
        return $this->validator->validate($this, $this->rules());
    }

    public function setObservers()
    {
        foreach ($this->observers() as $observer)
        {
            $this->observers[] = new $observer; 
        }
    }
} 
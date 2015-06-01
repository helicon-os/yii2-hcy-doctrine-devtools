<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace helicon\hcy\doctrine\devtools\gii\common;

/**
 * Description of Generator
 *
 * @author Andreas Prucha, Helicon Software Development
 */
class Generator extends \yii\gii\Generator
{
    public $dc = 'dc';  
    public $entityManager = 'default';
    public $baseClass = null;
    
    public function generate()
    {
        
    }

    public function getName()
    {
        
    }
    
    protected function getEm()
    {
        return \Yii::$app->{$this->dc}->getEm($this->entityManager);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['dc', 'entityManager'], 'filter', 'filter' => 'trim'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'dc' => 'Doctrine Component Id',
            'entityManager' => 'Entity Manager Id',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'dc' => 'Id of the doctrine component',
            'entityManager' => 'Id of the entity manager to use',
        ]);
    }
    

//put your code here
}

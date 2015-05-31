<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace helicon\hcyii2\doctrine\tools\dctools\console;

/**
 * Doctrine schema commands
 *
 * @author Andreas Prucha, Helicon Software Development
 */
class SchemaController extends \helicon\hcyii2\doctrine\tools\dctools\common\Controller
{
    /**
     * Updates the database schema
     * 
     * @param string $dc Configuration Id of the Doctrine component;
     * @param string $em Configuration Id of the entity manager;
     */
    public function actionUpdate($dc = 'dc', $em = null)
    {
        $dcInstance = \Yii::$app->$dc;
        if (!$dcInstance instanceof \helicon\hcyii2\doctrine\orm\DoctrineDb)
            throw new \yii\console\Exception($dc.' is not a valid doctrine component');
        $emInstance = $dcInstance->getEm($em);
        if (!$dcInstance instanceof \helicon\hcyii2\doctrine\orm\DoctrineDb)
            throw new \yii\console\Exception($em.' No valid entity manager specified');
    }
    
    public function actionDefault()
    {
        echo 'test';
    }
    
    public function actionIndex()
    {
        $this->run('/help', ['dctools/schema']);
    }
    
}

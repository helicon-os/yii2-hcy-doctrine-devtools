<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace helicon\hcy\doctrine\devtools\gii\generators\convert;

/**
 * Description of newPHPClass
 *
 * @author Andreas Prucha, Helicon Software Development
 */
class Generator extends \helicon\hcy\doctrine\devtools\gii\common\Generator
{
    
    public $ns = '';
    
    public $entityFieldVisibility = 'private';
    
    public $fromDb = false;
    
    /**
     * Format used for output
     * @var string 
     */
    public $outputFormat = null;
    
    /**
     * Output directory
     * 
     * @var String
     */
    public $outputDirectory = null;
    
    /**
     * @var mixed Prefix used for annotations or 0 for no prefix (simple annotation). Default is @ORM\\
     */
    public $annotationPrefix = '';
    
    public $backupExisting = 1;
    
    public $classToExtend = '\yii\base\model';
    
    public $fieldVisibility = 'private';
    
    public $generateStubmethods = 1;
    
    public $updateEntityIfExists = 1;
    
    public $regenerateEntityIfExists = 0;
    
    public $numSpaces = 4;
    
    public $generateAnnotations = 1;
    
    /**
     * @var string
     */
    public $namespace = '';
    
    /**
     * Extension oused for output-files
     * @var string 
     */
    public $fileExtension = null;
    
    public function getName()
    {
        return 'Doctrine reverse engineering';
    }

    public function getDescription()
    {
        return 'Generates mappings based on the the current database structure';
    }

    public function generate()
    {
        
        $em = $this->getEm();
        $re = new \helicon\doctrine\lib\tools\ReverseEngineer();
        $re->namespace = $this->namespace;
        $re->entityManager = $em;
        $metadata = $re->getMetadata();
        
        if ($this->outputFormat == 'annotation' ||
            $this->outputFormat == 'entity')
        {
            $entityGenerator = new \Doctrine\ORM\Tools\EntityGenerator();
            $entityGenerator->setGenerateAnnotations($this->generateAnnotations);
            $entityGenerator->setAnnotationPrefix($this->annotationPrefix);
            $entityGenerator->setBackupExisting($this->backupExisting);
            $entityGenerator->setClassToExtend($this->classToExtend);
            $entityGenerator->setFieldVisibility($this->fieldVisibility);
            $entityGenerator->setGenerateStubMethods($this->generateStubmethods);
            $entityGenerator->setUpdateEntityIfExists($this->updateEntityIfExists);
            $entityGenerator->setRegenerateEntityIfExists($this->regenerateEntityIfExists);
            $entityGenerator->setNumSpaces($this->numSpaces);
            $entityGenerator->setSkipNamespacePartInPath('app\\models\\entities\\');
            $entityGenerator->generate($metadata, \Yii::getAlias($this->outputDirectory));
        }
        else
        {
        
        $cme = new \Doctrine\ORM\Tools\Export\ClassMetadataExporter();
        $exporter = $cme->getExporter($this->outputFormat, \Yii::getAlias($this->outputDirectory));
        
        
        if (!empty($this->fileExtension))
        {
            $exporter->setExtension($extension);
        }
        $exporter->setMetadata($metadata);
        $exporter->export();
        }

        /*
        
        $exporter = \Doctrine\ORM\Tools\Export\Driver\XmlExporter::
        
        
        $generator = new \Doctrine\ORM\Tools\EntityGenerator();
        $generator->setAnnotationPrefix('');
        $generator->setUpdateEntityIfExists(true);
        $generator->setGenerateStubMethods(true);
        $generator->setGenerateAnnotations(true);
        $generator->setFieldVisibility($this->fieldVisibility);
        $generator->generate($metadata, $this->outputDirectory);
        */
    }
    
    /**
     * If database structure is reingeneered, This utility tries to auto-detect the output directory.
     */
    public function validateAutoOutputFormat()
    {
        if (empty($this->outputFormat))
        {
            
        }
    }
    
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['dc', 'entityManager', 'entityFieldVisibility', 'namespace'], 'filter', 'filter' => 'trim'],
            [['entityManager', 'outputFormat', 'outputDirectory'], 'required'],
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'baseClass' => 'This is the base class of the new ActiveRecord class. It should be a fully qualified namespaced class name.',
            'fromDb' => 'Generate entities from DB (Reverse Engineer)',
            'outputDirectory' => 'Where to geherate the entity classes. Yii aliases are allowed',
            'generateRelations' => 'This indicates whether the generator should generate relations based on
                foreign key constraints it detects in the database. Note that if your database contains too many tables,
                you may want to uncheck this option to accelerate the code generation process.',
            'generateLabelsFromComments' => 'This indicates whether the generator should generate attribute labels
                by using the comments of the corresponding DB columns.',
            'useTablePrefix' => 'This indicates whether the table name returned by the generated ActiveRecord class
                should consider the <code>tablePrefix</code> setting of the DB connection. For example, if the
                table name is <code>tbl_post</code> and <code>tablePrefix=tbl_</code>, the ActiveRecord class
                will return the table name as <code>{{%post}}</code>.',
            'annotationFieldVisibility' => 'Visibility of generated Fields. Should be <code>private</code> or <code>protected</code>',
            'fileExtension' => 'Extension used for output files. Format default is used if not specified',
            'namespace' => 'Namespace'
        ]);
    }
    

}

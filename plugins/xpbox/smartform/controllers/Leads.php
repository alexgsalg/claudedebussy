<?php namespace Xpbox\Smartform\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Leads extends Controller
{
    public $implement = ['Backend\Behaviors\ListController',
        'Backend\Behaviors\ReorderController',
        'Backend\Behaviors\ImportExportController',
        ];
    
    public $listConfig = 'config_list.yaml';
    public $reorderConfig = 'config_reorder.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Xpbox.Smartform', 'main-menu-item-form');
    }
}
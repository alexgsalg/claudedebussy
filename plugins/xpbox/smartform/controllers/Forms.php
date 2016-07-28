<?php namespace Xpbox\Smartform\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Forms extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController','Backend\Behaviors\ReorderController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'manager_forms' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Xpbox.Smartform', 'main-menu-item-form');
    }
}
<?php

namespace Xpbox\Smartform;

use System\Classes\PluginBase;

class Plugin extends PluginBase {

    public function registerComponents() {
        return [
            'Xpbox\SmartForm\Components\SmartForm' => 'smartForm'
        ];
    }

    public function registerSettings() {
        
    }

    public function registerMarkupTags() {
        return [
            'functions' => [
                'add_attributes_smartform' => function($formName, $smartForm = 'smartForm') {
                    $output = "action=\"#noaction\" data-request=\"$smartForm::onSubmitForm\" data-request-data=\"formName: '$formName'\"";
                    
                    return $output;
                }
            ]
        ];
    }

}

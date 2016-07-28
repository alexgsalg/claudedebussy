<?php namespace Xpbox\Smartform\Models;

class LeadsExport extends \Backend\Models\ExportModel
{
    public function exportData($columns, $sessionKey = null)
    {
        $subscribers = Leads::all();
        $subscribers->each(function($subscriber) use ($columns){
            $data = $subscriber->data;
            $subscriber->attributes['data'] = implode(',', $data);
            $subscriber->addVisible($columns);
             
        });
        
        return $subscribers->toArray();
    }
}

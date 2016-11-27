<?php namespace Xpbox\SmartForm\Components;

use Cms\Classes\ComponentBase;
use Xpbox\Smartform\Models\Form;
use Xpbox\Smartform\Models\Leads;
use Twig;
use Request;
use Mail;

class SmartForm extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'smartForm Component',
            'description' => 'SmartForm component.'
        ];
    }

    public function defineProperties()
    {
        return [
        'formName' => [
             'title'             => 'Name Form',
             'description'       => 'The name for HTML form',
             'type'              => 'string',
             'required'         => true,
             'validationMessage' => 'This field is required.'
        ]
    ];
    }
    
    public function onSubmitForm() {
        $data = Request::input();
        $formName = Request::input('formName');
        $form = Form::where('slug', $formName)->first();

        
        if (empty($form)) {
            throw new \Symfony\Component\Translation\Exception\NotFoundResourceException("Form name $formName not exists");
        }
        
        Leads::create(['form_id'=>$form->id, 'data'=>$data]);
        
        $this->sendMail($form, $data);
        
        return ['error'=>false, 'message'=> 'sucesso'];
    }
    
    private function sendMail(Form $form, array $data) {
        $messageHTML = Twig::parse(html_entity_decode($form->message), ['data'=>$data]);
        Mail::rawTo($this->getAddress($form->to), $messageHTML, function($message) use ($form, $data) {
            $message->subject($form->subject);

            if (isset($data['email'])) {
                $message->from($data['email']);
            }
        });
    }

    
    private function getAddress($addr) {
        $address = explode(',', $addr);
        
        array_walk($address, function($item, $k) use (&$address){
            $itemFiltered = trim($item);
            
            if (empty($itemFiltered)) {
                unset($address[$k]);
            }
            return trim($item);
        });
        
        return $address;
    }
    

}
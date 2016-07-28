<?php namespace Xpbox\Smartform\Models;

use Model;

/**
 * Model
 */
class Leads extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
    ];
    
    protected $jsonable = ['data'];
    protected $fillable = ['form_id', 'data'];
    protected $appends = ['form_name'];
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */

    /**
     * @var string The database table used by the model.
     */
    public $table = 'xpbox_smartform_leads';
    
    public $belongsTo = [
        'form' => 'Xpbox\Smartform\Models\Form'
    ];
    
    public function getFormNameAttribute() {
        return $this->form->slug;
    }
}
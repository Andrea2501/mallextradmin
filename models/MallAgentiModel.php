<?php namespace Tecnotrade\Mallextraadmin\Models;

use Model;

/**
 * Model
 */
class MallAgentiModel extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Hashable;


    /**
     * @var string table in the database used by the model.
     */
    public $table = 'tecnotrade_mallextraadmin_agenti';

    protected $hashable = ['password'];

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'email'  => 'required|email|unique:tecnotrade_mallextraadmin_agenti,email',
        'codice_agente'=>'required|unique:tecnotrade_mallextraadmin_agenti,codice_agente'
    ];

}

<?php
/**
 * Armazena casas de cambios que aceitam trocar moedas
 */

namespace Integrations\Models;

use Pedreiro\Models\Base;
use Telefonica\Models\Digital\Account;

class Token extends Base
{

    
    protected $organizationPerspective = false;

    public static $apresentationName = 'Tokens';

    protected $table = 'tokens';       

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id',
        'token',
        'obs',
        'scopes',
        'status'
    ];

     /**
      * The attributes that should be cast to native types.
      *
      * @var array
      */
    protected $casts = [
        'scopes' => 'json',
    ];

    protected $mappingProperties = array(

        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'status' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

    public $formFields = [
        [
            'name' => 'account_id',
            'label' => 'Account',
            'type' => 'select',
            'relationship' => 'account',
            'relFieldName' => 'email',
        ],
        [
            'name' => 'token',
            'label' => 'Token',
            'type' => 'text'
        ],
        [
            'name' => 'obs',
            'label' => 'Obs',
            'type' => 'textarea'
        ],
        [
            'name' => 'scopes',
            'label' => 'Scopes',
            'type' => 'text'
        ],
        // [
        //     'name' => 'slug',
        //     'label' => 'slug',
        //     'type' => 'text'
        // ],
        [
            'name' => 'status',
            'label' => 'Status',
            'type' => 'checkbox'
        ],
        // [
        //     'name' => 'status',
        //     'label' => 'Enter your content here',
        //     'type' => 'textarea'
        // ],
        // ['name' => 'publish_on', 'label' => 'Publish Date', 'type' => 'date'],
        // ['name' => 'tags', 'label' => 'Tags', 'type' => 'select_multiple', 'relationship' => 'tags'],
    ];

    public $indexFields = [
        'account_id',
        'token',
        'obs',
        'scopes',
        'status',
        // 'status'
    ];

    /**
     * Relation for the user that created this entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(
            Account::class,
            'account_id',
            'id'
        );
    }
}
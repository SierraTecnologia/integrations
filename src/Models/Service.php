<?php

namespace Integrations\Models;

use Pedreiro\Models\Base;

class Service extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'integration_id',
        'status'
    ];

    protected $mappingProperties = array(
        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'description' => [
            'type' => 'string',
            "analyzer" => "standard",
        ]
    );

    public function integration()
    {
        return $this->belongsTo(Integration::class);
    }

}

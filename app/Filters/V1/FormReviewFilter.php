<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class FormReviewFilter extends ApiFilter {

    protected $safeParms = [
        'name' => ['eq','lk'] ,
        'instructions' => ['eq','lk'] ,
        'rules' => ['eq','lk'] ,
        'form' => ['eq','lk'] ,
        'state' => ['eq','lk'] 
    ];

    protected $columnMap = [
        'name' => 'name',
        'instructions' => 'instructions',
        'rules' => 'rules',
        'form' => 'form',
        'state' => 'state',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '>',
        'gt' => '<=',
        'gte' => '>=',
        'lk' => 'like'

    ];





}
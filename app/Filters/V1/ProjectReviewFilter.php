<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;


class ProjectReviewFilter extends ApiFilter {

    protected $safeParms = [
        'project' => ['eq','lk'] ,
        'process' => ['eq','lk'] ,
        'reviewer' => ['eq','lk'] ,
        'par' => ['eq','lt','lte','gt','gte','ne'] ,
        'answer' => ['eq','lk'] 
    ];



    protected $columnMap = [
        'project' => 'project',
        'process' => 'process',
        'reviewer' => 'reviewer',
        'par' => 'par',
        'answer' => 'answer',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '>=',
        'gt' => '>',
        'gte' => '>=',
        'lk' => 'like',
        'ne' => '!=',

    ];





}
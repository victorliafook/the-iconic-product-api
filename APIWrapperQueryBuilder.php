<?php

namespace TheIconicAPIDumper;

class APIWrapperQueryBuilder
{
    const PARAMETERS_KEYS = [
        'gender' => 'gender',
        'page' => 'page',
        'pageSize' => 'page_size',
        'sort' => 'sort'
    ];
    
    private $queryParameters = [];
    
    public function gender($value)
    {
        $this->queryParameters[self::PARAMETERS_KEYS['gender']] = $value;
        return $this;
    }
    
    public function page($value)
    {
        $this->queryParameters[self::PARAMETERS_KEYS['page']] = $value;
        return $this;
    }
    
    public function pageSize($value)
    {
        $this->queryParameters[self::PARAMETERS_KEYS['pageSize']] = $value;
        return $this;
    }
    
    public function sort($value)
    {
        $this->queryParameters[self::PARAMETERS_KEYS['sort']] = $value;
        return $this;
    }
    
    public function build()
    {
        $paramsList = [];
        foreach($this->queryParameters as $paramKey => $paramValue) {
            $paramsList[] = "$paramKey=$paramValue";
        }
        
        $query = '?' . implode('&', $paramsList);
        return $query;
    }
}

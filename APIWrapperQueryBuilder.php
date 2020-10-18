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
    
    private $gender;
    private $page;
    private $pageSize;
    private $sort;
    
    public function gender($value)
    {
        $this->gender = $value;
        return $this;
    }
    
    public function page($value)
    {
        $this->page = $value;
        return $this;
    }
    
    public function pageSize($value)
    {
        $this->pageSize = $value;
        return $this;
    }
    
    public function sort($value)
    {
        $this->sort = $value;
        return $this;
    }
    
    public function build()
    {
        $queryParamsList = [];
        $queryParamsList[] = $this->getParameterString('gender', $this->gender);
        $queryParamsList[] = $this->getParameterString('page', $this->page);
        $queryParamsList[] = $this->getParameterString('pageSize', $this->pageSize);
        $queryParamsList[] = $this->getParameterString('sort', $this->sort);
        
        $query = '?';
        return $query . implode($queryParamsList, '&');
    }
    
    private function getParameterString($paramKey, $paramValue)
    {
        if ($this->{$paramKey}) {
            return self::PARAMETERS_KEYS[$paramKey] . '=' . $paramValue;
        }
        
        return '';
    }
}

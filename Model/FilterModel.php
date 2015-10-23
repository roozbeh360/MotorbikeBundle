<?php

namespace Rth\MotorbikeBundle\Model ;

class FilterModel
{
    private $em;
    private $request ;
    private $filterFields ;
    
    function __construct($em,$request,$filterString)
    {
        $this->em = $em;
        $this->request = $request;
        
        $tFields = explode(',', $filterString);
        
        foreach ($tFields as $tField)
        {
            $fv = explode(':', $tField);
            $this->filterFields[$fv[0]] = $fv[1] ;
        }
        
    }
    
    public function filterFields()
    {
        return $this->filterFields;
    }

    public function filterQueryBuilder()
    {
        $filterFieldNames = $this->filterFields();
        $query = '  ';
        $queryFields = [];
        foreach ($filterFieldNames as $fieldName => $fieldType) {
            if ($this->request->query->has($fieldName) && $fieldType == 'text') {
                $fieldValue = $this->request->query->get($fieldName);
                $queryFields[] = " a.$fieldName LIKE '%$fieldValue%' ";
            }
        }
        if (count($queryFields) > 0) {
            $query = ' WHERE ' . implode(' OR ', $queryFields);
        }
        return $query;
    }
}

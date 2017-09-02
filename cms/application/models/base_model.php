<?php
interface Base_model {
    //CRUD
    function selectAll();
    function selectById($id);
    function removeById($id);
    function updateById($id, $data);
    function insert($data);
    //--end CRUD
    
    //formed data
    function FormData($data);
}
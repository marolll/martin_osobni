<?php

declare(strict_types=1);

namespace App\Model;

use Nette;


/**
 * PreviewFactory
 */
final class PreviewFactory
{
	use Nette\SmartObject;



	/** @var Nette\Database\Context */
	private $db;


	public function __construct(Nette\Database\Context $db)
	{
		$this->db = $db;
	}

        public function providePreview($table, $page, $redirect_route, $request, $limit, $search_values, $presenter)
        {
            $template = [];
            $params = $request->getQuery();
            if(is_null($page))
            {
                $offset = 0;
                $page = 1;
            }
            else {
                $offset = ($page - 1) * $limit;
            }
            if(empty($params))
            {
                $all = $this->getAll($table, $limit, $offset);
                $all_count = $this->getAllCount($table);
                $template['result_type'] = "normal";
            }
            else
            {
                $all = $this->search($table, $search_values, $limit, $offset, "all");
                $all_count = $this->search($table, $search_values, $limit, $offset, "count");
                $template['params'] = $params;
                $template['result_type'] = "search";
            }

            if($offset >= $all_count->count && $all_count->count !=0)
            {
//                $this->redirect(":Admin:Unit:previewUnit", 1);
                $presenter->redirect($redirect_route, 1);
            }
            $template['all'] = $all;
            $template['all_count'] = $all_count;
            $template['page'] = $page;
            $template['limit'] = $limit;
            $template['redirect_route'] = $redirect_route;
            return $template;
        }
        
        
        public function getAll($table = false, $limit = false, $offset = false)
        {
            if($limit !== false && $offset !== false)
            {
                $get = $this->db->table($table)->limit($limit, $offset)->fetchAll();
            }
            else
            {
                $get = $this->db->table($table)->fetchAll();
            }
            return $get;
        }
        
        public function getAllCount($table = false)
        {
            $get = $this->db->table($table)->select("COUNT(*) AS count")->fetch();
            return $get;
        }
        
        public function search($table, $values, $limit, $offset, $type)
        {
            $ao = "";
            $out = [];
//            foreach($values as $line)
            $order = [];
            for($j = 0; $j < count($values)-1; $j++)
            {
                if($values[$j][1] == "equal")
                {
                    if($values[$j][2] !== "0")
                    {
                        $out[] = $values[$j][0] . " = " . $values[$j][2];
                    }
                }
                else if($values[$j][1] == "like")
                {
                    if($values[$j][2] !== "")
                    {
                        $out[] = $values[$j][0] . " LIKE '%" . $values[$j][2] . "%'";
                    }
                }
                else if($values[$j][1] == "greater_equal")
                {
                    if($values[$j][2] !== "")
                    {
                        if(isset($values[$j][3]))
                        {
                            $out[] = $values[$j][3] . " >= '" . $values[$j][2] . "'";
                        }
                        else
                        {
                            $out[] = $values[$j][0] . " >= '" . $values[$j][2] . "'";
                        }
                    }
                }
                else if($values[$j][1] == "lower_equal")
                {
                    if($values[$j][2] !== "")
                    {
                        if(isset($values[$j][3]))
                        {
                            $out[] = $values[$j][3] . " <= '" . $values[$j][2] . "'";
                        }
                        else
                        {
                            $out[] = $values[$j][0] . " <= '" . $values[$j][2] . "'";
                        }
                    }
                }
                else if($values[$j][0] == "and_or")
                {
                    if($values[$j][2] == "and")
                    {
                        $ao = " AND ";
                    }
                    else if($values[$j][2] == "or")
                    {
                        $ao = " OR ";
                    }
                }
                else if($values[$j][0] == "order")
                {
                    if($values[$j][2])
                    {
                        for($i = 0; $i < count($values[$j][2]); $i++)
                        {
                            $order[] = $values[$j][2][$i] . " " . $values[$j+1][2][$i];
                        }
                    }
                }
            }
            
//            if($and_or == "and")
//            {
//                $ao = " AND ";
//            }
//            else if($and_or == "or")
//            {
//                $ao = " OR ";
//            }

//            $out = [];
//            if($cs_id != "")
//            {
//                $out[] = "acc_id LIKE '%" . $cs_id . "%'";
//            }
//            if($cs_type != "0")
//            {
//                $out[] = "acc_type = " . $cs_type . "";
//            }
//            if($cs_name != "")
//            {
//                $out[] = "CONCAT(U1.use_name, ' ', U1.use_surname) LIKE '%" . $cs_name . "%'";
//            }
//            if($cs_status != "0")
//            {
//                $out[] = "acc_status = '" . $cs_status . "'";
//            }
//            if($cs_user != "")
//            {
//                $tmp = "( CONCAT(U2.use_name, ' ', U2.use_surname) LIKE '%" . $cs_user . "%'";
//                if(strpos("nepřevzato", strtolower($cs_user)) !== false)
//                {
//                    $tmp .= " OR usa_id_to IS NULL ";
//                }
//                $tmp .= ")";
//                $out[] = $tmp;
//            }

            $sql = implode($ao, $out);
            if($sql != "")
            {
                $sql = " WHERE " . $sql;
            }
            $or = implode(", ", $order);
            if($or != "")
            {
                $or = "ORDER BY " . $or;
            }
            if($type == "all")
            {
                $tp = $table . ".*";
                if($limit != false)
                {
                    $get = $this->db->query("SELECT " . $tp . " FROM " . $table . " " . $sql . " " . $or .  " LIMIT ? OFFSET ?", $limit, $offset)->fetchAll();
                }
                else
                {
                    $get = $this->db->query("SELECT " . $tp . " FROM " . $table . " " . $sql . " " . $or)->fetchAll();
                }
                
                
            }
            else if($type == "count")
            {
                $tp = "COUNT(*) AS count ";
                $get = $this->db->query("SELECT " . $tp . " FROM " . $table . " " . $sql)->fetch();
            }
            
            
            return $get;
        }
}



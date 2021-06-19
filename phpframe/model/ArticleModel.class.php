<?php
pc_base::load_sys_class('BaseModel');

class ArticleModel extends BaseModel
{

    public function getItemById($id) {
        return $this->where(array('article_id'=>$id))->find();
    }
    
    public function getLists($filter, $page = 1, $page_size)
    {
        $where = '1 and a.is_del = 0 ';
        if (isset($filter['title']) && $filter['title'] != '') {
            $where .= " and a.title like '%" . $filter['title'] . "%'";
        }
        if (isset($filter['intro']) && $filter['intro'] != '') {
            $where .= " and a.intro like '%" . $filter['intro'] . "%'";
        }
        if (isset($filter['status']) && $filter['status'] != '') {
            $where .= " and a.status '" . $filter['status'] . "'";
        }
        // 排序条件
        if (isset($filter['order']) && $filter['order'] != '') {
            $order = " ORDER BY a." . $filter['order'] . " DESC ";
        } else {
            $order = ' ORDER BY a.sort DESC ';
        }
        $limit = ($page - 1) * $page_size . ',' . $page_size;
        $sql = "select * from smjd_article a where $where $order limit " . $limit;
        $rs = $this->query($sql);
        return $rs;
    }

    public function getCounts($filter)
    {
        $where = '1';
        if (isset($filter['title']) && $filter['title'] != '') {
            $where .= " and a.title like '%" . $filter['title'] . "%'";
        }
        if (isset($filter['intro']) && $filter['intro'] != '') {
            $where .= " and a.intro like '%" . $filter['intro'] . "%'";
        }
        if (isset($filter['status']) && $filter['status'] != '') {
            $where .= " and a.status '" . $filter['status'] . "'";
        }
        $sql = "
	        select count(1) as num from smjd_article a where $where 
	        ";
        $rs = $this->query($sql);
        return $rs[0]['num'];
    }

    public function getMaxSort()
    {
        $sql = "select max(a.sort) as max_sort from smjd_article a";
        $rs = $this->query($sql);
        return $rs[0]['max_sort'];
    }
}

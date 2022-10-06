<?php
  
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
// set number of records per page
$records_per_page = 50;
  
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

class Utilities{
	
	public function getPaging($page, $total_rows, $records_per_page, $page_url){
		//paging array
		$paging_arr=array();
		
		//button for first page
		$paging_arr["first"]=$page>1?"{$page_url}page=1" : "";
		
		//count all products iin the database to calculate total pages
		$total_pages = ceil($total_rows/$records_per_page);
		//console_log($total_pages);
		
		//range of links to show
		$range = 2;
		
		//display links to 'range of pages' around 'current page'
		$initial_num = $page-$range;
		$condition_limit_num=($page+$range)+1;
		
		$paging_arr['pages']=array();
		$page_count=0;
		
		for($x=$initial_num; $x<$condition_limit_num; $x++){
            // be sure '$x is greater than 0' AND 'less than or equal to the $total_pages'
            if(($x > 0) && ($x <= $total_pages)){
                $paging_arr['pages'][$page_count]["page"]=$x;
                $paging_arr['pages'][$page_count]["url"]="{$page_url}page={$x}";
                $paging_arr['pages'][$page_count]["current_page"] = $x==$page ? "yes" : "no";
  
                $page_count++;
            }
        }
		//$paging_arr["num"]=($total_rows);
        // button for last page
        $paging_arr["last"] = $total_pages;//$page<$total_pages ? "{$page_url}page={$total_pages}" : "";
		$paging_arr["totalRows"]=$total_rows;
        // json format
        return $paging_arr;
    }
	
}

?>
<?php
/**
 * @author wherrera
 */
class Paginator {    
    private $itemsPerPage   = 5;
    private $totalItems     = 0;
    private $currentPage    = 0;
    
    public function setItemsPerPage($itemsPerPage) {
       $this->itemsPerPage = (int)$itemsPerPage;
    }
    
    public function setTotalItems($totalItems) {
       $this->totalItems = (int)$totalItems;
    }
    
    public function setCurrentPage($currentPage) {
       $this->currentPage = (int)$currentPage;
    }
    
    public function getCurrentItem() {
        return $this->currentPage * $this->itemsPerPage;
    }
    
    public function getLimitQuery() {
        return "limit " . $this->getCurrentItem() . "," . $this->itemsPerPage;
    }
    
    private function createParamValue($params = array()) {
        $str = "";
        foreach ($params as $key => $value) {
            if(strlen($str)>0) {
                $str .= "&";
            }
            $str .= $key . "=" . urlencode($value);
        }
        if(strlen($str) > 0) {
            return "&" . $str;
        } else {
            return "";
        }
    }
    
    public function createLinks($url = "", $params = array() ) {                       
        $item = $this->getCurrentItem();
        $totalpages = ceil( $this->totalItems / $this->itemsPerPage );        
        $append = 0;
        $startPage = $this->currentPage - 4;        
        if($startPage < 0) {
            $startPage = 0;
            $append = abs($this->currentPage - 4);
        }
        $endPage = $this->currentPage + 4 + $append;
        if($endPage > $totalpages) {
            $endPage = $totalpages;
        }
        $param = $this->createParamValue($params);        
        if($this->currentPage > 0) {
            echo "<a class=\"page-select\" href=\"$url?page=0$param\">first</a>";
        }
        for($i = $startPage; $i < $endPage; $i++) { 
            $id = "";
            if($i == $this->currentPage) {
                $id = 'current-page';
            } else {
                $id = 'page-' . $id;
            }
            echo '<a id="' . $id . '" class="page-select" href="' . $url. '?page=' . $i . $param . '">' . ($i+1) . '</a>';
        }
        if($this->currentPage < $totalpages-1) {
            echo '<a class="page-select" href="' . $url . '?page=' . ($totalpages-1) . $param . '">last</a>';
        }
    }
}
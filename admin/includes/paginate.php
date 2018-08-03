<?php

class Paginate {
    public $page;
    public $items_per_page;
    public $items_total_count;

    public function __construct($page = 1, $items_per_page = 4, $items_total_count = 0) {
        $this->current_page = (int)$page;
        $this->items_per_page = (int)$items_per_page;
        $this->items_total_count = (int)$items_total_count;
    }

    // to next page
    public function next() {
        return $this->current_page + 1;
    }

    // to previous page
    public function previous() {
        return $this->current_page - 1;
    }

    // total page count
    public function page_total() {
        return ceil($this->items_total_count/$this->items_per_page);
    }

    // find out if there's a next page
    public function has_next() {
        return $this->next() <= $this->page_total() ? true : false;
    }

    // find out if there's a previous page
    public function has_previous() {
        return $this->previous() >= 1 ? true : false;
    }

    // offset
    public function offset() {
        return ($this->current_page -1) * ($this->items_per_page);
    }
}


?>
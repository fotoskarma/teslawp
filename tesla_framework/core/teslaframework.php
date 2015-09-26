<?php

class TeslaFramework {
    
    protected $load;
    
    function __construct(){
        $this->load = new TT_Load;
    }

    function autoload() {
        $this->autoload_admin_panel();
    }

    private function autoload_admin_panel() {
        $this->admin_init();
    }

}

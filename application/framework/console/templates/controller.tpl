<?php
/** -----------------------------------------------------------------------
 * Controller @name
 * ------------------------------------------------------------------------
 * #
 * 
 * @category Controllers
 * @version 1.0.0
 * @author name <name@email.com>
 */
class @nameController extends Controller 
{
    function __construct() {
		parent::__construct(__CLASS__);
		
		/**
		* Default template in which views are rendered
		*/
        $this->view->template ("template");

		/**
		* This global variable saves an instance 
		* in a table that matches the class name
		*/
		$this->model_base = $this->load_model('@name');

		/**
		* Avoid caching
		*/
        $this->no_cache();
    }



    /** -----------------------------------------------------------------------
     * Default Index Method
     * ------------------------------------------------------------------------
     * #
     * 
     * @author name <name@email.com>
     */
    public function index(){
        

        $this->view->theme( FRONTEND );
        $this->view->template( 'default' );
        $this->view->render( __FUNCTION__ );
    }
}


?>
<?php

namespace passster;

if ( !class_exists( '\\WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'class-wp-list-table.php';
}
class PS_List_Table extends \WP_List_Table
{
    /**
     * PS_List_Table constructor
     */
    public function __construct()
    {
    }
    
    /**
     * Add edit and delete links under group title
     *
     * @param object $item the current item object.
     * @return void
     */
    public function column_password_list( $item )
    {
    }
    
    /**
     * Add column for expire passwords
     *
     * @param object $item current item object.
     *
     * @return string
     */
    public function column_expire_passwords( $item )
    {
    }
    
    /**
     * Add column for expire passwords
     *
     * @param object $item current item object.
     *
     * @return string
     */
    public function column_shortcode( $item )
    {
    }
    
    /**
     * Get all columns
     *
     * @return array
     */
    public function get_columns()
    {
    }
    
    /**
     * Get sortable columns
     *
     * @return array
     */
    public function get_sortable_columns()
    {
    }
    
    /**
     *  Prepare loop for output
     */
    public function prepare_items()
    {
    }
    
    /**
     * Modify usort for reordering groups
     *
     * @param string $a orderby parameter.
     * @param string $b order parameter.
     *
     * @return int
     */
    public function usort_reorder( $a, $b )
    {
    }

}
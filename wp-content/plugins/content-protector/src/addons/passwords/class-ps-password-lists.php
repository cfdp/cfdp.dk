<?php

namespace passster;

class PS_Password_Lists
{
    /**
     * @var string|void the current page slug.
     */
    public  $slug ;
    /**
     * @var string the admin url
     */
    public  $password_list_admin_url ;
    /**
     * PS_Password_Lists constructor.
     */
    public function __construct()
    {
    }
    
    /**
     * Initialize settings area
     *
     * @return void
     */
    public function init()
    {
    }
    
    /**
     * Output expire meta field
     *
     * @param int $password_list_id current list id.
     * @return void
     */
    public function expire_passwords_output( $password_list_id )
    {
    }
    
    /**
     * Output password fields
     *
     * @param int $password_list_id current list id.
     * @return void
     */
    public function passwords_output( $password_list_id )
    {
    }
    
    /**
     * Save post and metadata
     *
     * @param int $password_list_id current list id.
     * @return void
     */
    public function save( $password_list_id )
    {
    }

}
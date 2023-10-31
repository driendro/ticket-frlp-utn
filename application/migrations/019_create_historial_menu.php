<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_historial_menu extends CI_Migration 
{
    public function up() 
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
				'auto_increment' => TRUE
            ],
            'id_vendedor'=> [
                'type' => 'INT',
                'constraint' => '10',
                'unsigned' => TRUE
            ],
            'id_dia' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'menu1' => [
                'type' => 'TEXT'
            ],
            'menu2' => [
                'type' => 'TEXT'
            ],
            'menu3' => [
                'type' => 'TEXT'
            ],
            'fecha' => [
                'type' => 'DATE',
            ]
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('historial_menu');
    }

    public function down() 
    {
        $this->dbforge->drop_table('historial_menu');
    }
}
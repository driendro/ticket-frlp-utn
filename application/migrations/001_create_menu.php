<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_menu extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => '2',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'dia' => [
                'type' => 'VARCHAR',
                'constraint' => '9'
            ],
            'menu1' => [
                'type' => 'TEXT'
            ],
            'menu2' => [
                'type' => 'TEXT'
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('menu');
    }
    public function down()
    {
        $this->dbforge->drop_table('menu');
    }
}

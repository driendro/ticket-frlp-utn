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
            ],
            'menu3' => [
                'type' => 'TEXT'
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('menu');

        $data = [
            ['id' => 1, 'dia' => 'Lunes',     'menu1' => '', 'menu2' => '', 'menu3' => ''],
            ['id' => 2, 'dia' => 'Martes',    'menu1' => '', 'menu2' => '', 'menu3' => ''],
            ['id' => 3, 'dia' => 'Miércoles', 'menu1' => '', 'menu2' => '', 'menu3' => ''],
            ['id' => 4, 'dia' => 'Jueves',    'menu1' => '', 'menu2' => '', 'menu3' => ''],
            ['id' => 5, 'dia' => 'Viernes',   'menu1' => '', 'menu2' => '', 'menu3' => '']
        ];

        $this->db->insert_batch('menu', $data);
    }
    public function down()
    {
        $this->dbforge->drop_table('menu');
    }
}

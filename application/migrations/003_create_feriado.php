<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_feriado extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'fecha' => [
                'type' => 'DATE'
            ],
            'detalle' => [
                'type' => 'VARCHAR',
				'constraint' => '100'
            ]
        ]);

        $this->dbforge->create_table('feriado');

        $data = [
            ['fecha' => '2022-04-19', 'detalle' => 'Milanesa con papa fritas'],
            ['fecha' => '2022-04-21', 'detalle' => 'Pastel de papas'],
            ['fecha' => '2022-04-23', 'detalle' => 'Arroz con pollo'],
            ['fecha' => '2022-04-27', 'detalle' => 'Carne y ensalada'],
            ['fecha' => '2022-04-29', 'detalle' => 'Verdura hervida']
        ];

        $this->db->insert_batch('feriado', $data);
    }
    public function down()
    {
        $this->dbforge->drop_table('feriado');
    }
}

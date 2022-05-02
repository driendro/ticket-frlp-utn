<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_menu extends CI_Migration
{
	public function up()
	{
		$this->dbforge->add_field([
			'id' => [
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			],
			'dia' => [
				'type' => 'VARCHAR',
				'constraint' => '9'
			],
			'numero' => [
				'type' => 'INT',
				'constraint' => '2',
				'unsigned' => TRUE
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

		$data = [
			['id' => 1, 'dia' => 'Lunes', 'numero' => 1, 'menu1' => 'Milanesa con papa fritas', 'menu2' => 'Milanesa con papa fritas'],
			['id' => 2, 'dia' => 'Martes', 'numero' => 2, 'menu1' => 'Pastel de papas', 'menu2' => 'Pastel de papas'],
			['id' => 3, 'dia' => 'Miércoles', 'numero' => 3, 'menu1' => 'Arroz con pollo', 'menu2' => 'Arroz con pollo'],
			['id' => 4, 'dia' => 'Jueves', 'numero' => 4, 'menu1' => 'Carne y ensalada', 'menu2' => 'Carne y ensalada'],
			['id' => 5, 'dia' => 'Viernes', 'numero' => 5, 'menu1' => 'Verdura hervida', 'menu2' => 'Verdura hervida']
		];

		$this->db->insert_batch('menu', $data);
	}
	public function down()
	{
		$this->dbforge->drop_table('menu');
	}
}
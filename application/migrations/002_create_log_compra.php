<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_log_compra extends CI_Migration
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
			'fecha' => [
				'type' => 'DATE'
			],
			'hora' => [
				'type' => 'TIME'
			],
			'dia_comprado' => [
				'type' => 'DATE'
			],
			'id_usuario' => [
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => TRUE
			],
			'precio' => [
				'type' => 'INT',
				'constraint' => '4',
				'unsigned' => TRUE
			],
			'tipo' => [
				'type' => 'VARCHAR',
				'constraint' => '10',
			],
			'turno' => [
				'type' => 'VARCHAR',
				'constraint' => '15',
				'default' => null,
			],
			'menu' => [
				'type' => 'VARCHAR',
				'constraint' => '10',
			]
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('log_compra');
	}

	public function down()
	{
		$this->dbforge->drop_table('log_compra');
	}
}
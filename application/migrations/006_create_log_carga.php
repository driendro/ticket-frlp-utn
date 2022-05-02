<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_log_carga extends CI_Migration
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
			'id_usuario' => [
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => TRUE
			],
			'monto' => [
				'type' => 'INT',
				'constraint' => '5',
				'unsigned' => TRUE
			],
			'id_vendedor' => [
				'type' => 'INT',
				'constraint' => '10',
				'unsigned' => FALSE
			]
		]);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('log_carga');
	}

	public function down()
	{
		$this->dbforge->drop_table('log_carga');
	}
}
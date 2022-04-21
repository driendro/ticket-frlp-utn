<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_usuarios extends CI_Migration
{
	public function up()
	{
		$this->dbforge->add_field([
			'tipo' => [
				'type' => 'VARCHAR',
				'constraint' => '20'
			],
			'legajo' => [
				'type' => 'INT',
				'constraint' => '5'
			],
			'documento' => [
				'type' => 'INT',
				'constraint' => '8'
			],
			'pass' => [
				'type' => 'VARCHAR',
				'constraint' => '32'
			],
			'nombre' => [
				'type' => 'VARCHAR',
				'constraint' => '50'
			],
			'apellido' => [
				'type' => 'VARCHAR',
				'constraint' => '50'
			],
			'especialidad' => [
				'type' => 'VARCHAR',
				'constraint' => '10',
				'null' => TRUE,
				'blank' => TRUE
			],
			'mail' => [
				'type' => 'VARCHAR',
				'constraint' => '50'
			],
			'saldo' => [
				'type' => 'INT',
				'constraint' => '5'
			],
			'estado' => [
				'type' => 'BOOLEAN',
				'default' => TRUE
			],
			'id_precio' => [
				'type' => 'INT',
				'constraint' => '2'
			],
		]);

        $this->dbforge->create_table('usuarios');

        $data = [
            ['tipo' => 'Estudiante', 'legajo' => 23364 ,'documento'=>35299781, 'pass'=>'1234', 'nombre'=>'Jorge', 'apellido'=>'Ronconi', 'especialidad'=>'Civil', 'mail'=>'jorge.ronconi@gmail.com', 'saldo'=>5000,'estado'=>TRUE,'id_precio'=>1],
            ['tipo' => 'Estudiante', 'legajo' => 23364 ,'documento'=>35299782, 'pass'=>'1234', 'nombre'=>'Jorge', 'apellido'=>'Ronconi', 'especialidad'=>'Civil', 'mail'=>'jorge.ronconi@gmail.com', 'saldo'=>5000,'estado'=>TRUE,'id_precio'=>2],
            ['tipo' => 'Docente'   , 'legajo' => 23364 ,'documento'=>35299783, 'pass'=>'1234', 'nombre'=>'Jorge', 'apellido'=>'Ronconi', 'especialidad'=>'Civil', 'mail'=>'jorge.ronconi@gmail.com', 'saldo'=>5000,'estado'=>TRUE,'id_precio'=>3],
            ['tipo' => 'No Docente', 'legajo' => 23364 ,'documento'=>35299784, 'pass'=>'1234', 'nombre'=>'Jorge', 'apellido'=>'Ronconi', 'especialidad'=>'Civil', 'mail'=>'jorge.ronconi@gmail.com', 'saldo'=>5000,'estado'=>TRUE,'id_precio'=>4]
        ];

        $this->db->insert_batch('usuarios', $data);
    }
    public function down()
    {
        $this->dbforge->drop_table('usuarios');
    }
}
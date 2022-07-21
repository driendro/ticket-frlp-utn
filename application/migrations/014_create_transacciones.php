<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_transacciones extends CI_Migration
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
            'transaccion' => [
                'type' => 'VARCHAR',
                'constraint' => '20'
            ],
            'monto' => [
                'type' => 'INT',
                'constraint' => '5',
            ],
            'saldo' => [
                'type' => 'VARCHAR',
                'constraint' => '5'
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('transacciones');
    }

    public function down()
    {
        $this->dbforge->drop_table('transacciones');
    }
}
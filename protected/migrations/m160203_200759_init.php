<?php

class m160203_200759_init extends CDbMigration
{
	public function up()
	{
		$this->createTable('tbl_user', array(
      'id' => 'pk',
      'username' => 'string NOT NULL',
      'password' => 'string NOT NULL'
    ));

		$this->createTable('tbl_token', array(
      'id' => 'pk',
      'token' => 'string NOT NULL',
      'user' => 'int NOT NULL'
    ));

		$this->createTable('tbl_article', array(
      'id' => 'pk',
      'title' => 'string NOT NULL',
      'slug' => 'string NOT NULL',
      'text' => 'text',
      'author' => 'int NOT NULL'
    ));

    $this->insert('tbl_user', array(
      'username' => 'admin',
      'password' => '$2y$13$QPgXh2X9fGABsLh5OipzreIiOIUWhGwt4cGtSMpvkUf9vA6DNyiKq'
    ));
	}

	public function down()
	{
		echo "m160203_200759_init does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
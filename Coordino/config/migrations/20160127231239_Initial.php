<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('badges');
        $table
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('timestamp', 'integer', [
                'default' => null,
                'limit' => 12,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 12,
                'null' => false,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->create();

        $table = $this->table('comments');
        $table
            ->addColumn('related_id', 'integer', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('content', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('timestamp', 'integer', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('votes', 'integer', [
                'default' => null,
                'limit' => 5,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->create();

        $table = $this->table('histories');
        $table
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('related_id', 'integer', [
                'default' => null,
                'limit' => 25,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 25,
                'null' => false,
            ])
            ->addColumn('timestamp', 'integer', [
                'default' => null,
                'limit' => 25,
                'null' => false,
            ])
            ->create();

        $table = $this->table('post_tags', ['id' => false]);
        $table
            ->addColumn('post_id', 'integer', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('tag_id', 'integer', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $table = $this->table('posts');
        $table
            ->addColumn('type', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('related_id', 'integer', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('content', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('status', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('timestamp', 'integer', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('last_edited_timestamp', 'integer', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('votes', 'integer', [
                'default' => null,
                'limit' => 5,
                'null' => false,
            ])
            ->addColumn('url_title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('public_key', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('views', 'integer', [
                'default' => 1,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('tags', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('flags', 'integer', [
                'default' => null,
                'limit' => 3,
                'null' => false,
            ])
            ->addColumn('notify', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $table = $this->table('posts_revs', ['id' => false, 'primary_key' => ['version_id']]);
        $table
            ->addColumn('version_id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('version_created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('id', 'integer', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('type', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('related_id', 'integer', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('content', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('status', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('timestamp', 'integer', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('last_edited_timestamp', 'integer', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('votes', 'integer', [
                'default' => null,
                'limit' => 5,
                'null' => false,
            ])
            ->addColumn('url_title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('public_key', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('views', 'integer', [
                'default' => 1,
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('tags', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('flags', 'integer', [
                'default' => null,
                'limit' => 3,
                'null' => true,
            ])
            ->create();

        $table = $this->table('settings');
        $table
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('value', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('autoload', 'integer', [
                'default' => 0,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $table = $this->table('tags');
        $table
            ->addColumn('tag', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $table = $this->table('users');
        $table
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('url_title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('joined', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('reputation', 'integer', [
                'default' => 0,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('website', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('location', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('age', 'integer', [
                'default' => null,
                'limit' => 3,
                'null' => true,
            ])
            ->addColumn('info', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('permission', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('ip', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('answer_count', 'integer', [
                'default' => 0,
                'limit' => 12,
                'null' => false,
            ])
            ->addColumn('comment_count', 'integer', [
                'default' => 0,
                'limit' => 12,
                'null' => false,
            ])
            ->addColumn('question_count', 'integer', [
                'default' => 0,
                'limit' => 12,
                'null' => false,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('reset_key', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true
            ])
            ->addColumn('reset_timestamp', 'timestamp', [
                'default'=>null,
                'null' => true
            ])
            ->create();

        $table = $this->table('votes');
        $table
            ->addColumn('post_id', 'integer', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('timestamp', 'integer', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('type', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $table = $this->table('widgets');
        $table
            ->addColumn('page', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('location', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('content', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('global', 'integer', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->create();

    }

    public function down()
    {
        $this->dropTable('badges');
        $this->dropTable('comments');
        $this->dropTable('histories');
        $this->dropTable('post_tags');
        $this->dropTable('posts');
        $this->dropTable('posts_revs');
        $this->dropTable('settings');
        $this->dropTable('tags');
        $this->dropTable('users');
        $this->dropTable('votes');
        $this->dropTable('widgets');
    }
}

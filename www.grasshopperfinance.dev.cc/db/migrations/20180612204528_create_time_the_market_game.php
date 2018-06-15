<?php


use Phinx\Migration\AbstractMigration;

class CreateTimeTheMarketGame extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other distructive changes will result in an error when trying to
     * rollback the migration.
     */
    public function change()
    {
        // Table to store list of all plays for the time the market game
        $table = $this->table('time_the_market_plays');
        $table->addColumn('game_start_time', 'datetime')
              ->addColumn('game_end_time', 'datetime')
              ->addColumn('ip_address', 'string')
              ->addColumn('num_trades', 'integer')
              ->addIndex(['num_trades'])
              ->addColumn('start_money', 'decimal', ['precision' => 20, 'scale' => 2])
              ->addColumn('my_end_money', 'decimal', ['precision' => 20, 'scale' => 2])
              ->addIndex(['my_end_money'])
              ->addColumn('market_end_money', 'decimal', ['precision' => 20, 'scale' => 2])
              ->addColumn('market_start_date', 'datetime')
              ->addColumn('market_end_date', 'datetime')
              ->addColumn('beat_market_by_dollars', 'decimal', ['precision' => 20, 'scale' => 2])
              ->addIndex(['beat_market_by_dollars'])
              ->addColumn('beat_market_by_percent', 'float')
              ->addIndex(['beat_market_by_percent'])
              ->addColumn('did_beat_market', 'boolean')
              ->addIndex(['did_beat_market'])
              ->create();

    }
}

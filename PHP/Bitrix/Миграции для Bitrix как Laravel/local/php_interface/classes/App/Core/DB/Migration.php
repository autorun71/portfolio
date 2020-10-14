<?php


namespace App\Core\DB;


use App\Core\Main;
use App\Service\CLI;
use App\Model\Migration as MigrationModel;
use Bitrix\Main\DB\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

/**
 * Class Migration
 * @package App\Core\DB
 */
abstract class Migration
{
    abstract function up();

    abstract function down();

    public static function run()
    {
        $migrations = self::toArray(Main::getMigrations());
        $count = 0;
        foreach ($migrations as $migration) {
            try {
                $selectMigrate = MigrationModel::where('class', $migration['class'])->get()->toArray();
                if (!empty($selectMigrate)) {
                    continue;
                }
            }catch (QueryException $e){
                CLI::error('Not exist migrations table!');
            }

            $count++;
            CLI::success($migration['class'] . " migrate");
            require_once($migration['path']);
            /**
             * @var self
             */
            $migrate = new $migration['class'];
            try {
                $migrate->up();
                $Migration = new MigrationModel();

                $Migration->class = $migration['class'];
                $Migration->save();
                CLI::success($migration['class'] . " was migrated!");

            } catch (\Exception $e) {
                CLI::error($migration['class'] . " was'nt migrated!");
                CLI::error("Error: " . $e->getMessage());
                break;
            }
        }
        if ($count == 0){
            CLI::success('Nothing migrate!');
        }
    }

    public static function rollback($limit = 5)
    {
        $migrations = self::toArray(Main::getMigrations());
        /**
         * @var Collection
         */
        $allMigrations = (new MigrationModel)->newQuery()->where('class', '!=', 'CreateMigrationsTable')->orderBy('ID', 'desc')->take($limit)->get();

        $count = 0;
        foreach ($allMigrations as $migration) {

            $selectMigration = array_filter($migrations, function ($item) use ($migration) {
                return $item['class'] == $migration['class'];
            });

            if (empty($selectMigration)) {
                continue;
            }

            $count++;
            $selectMigration = array_shift($selectMigration);

            CLI::success($selectMigration['class'] . " start rollback");
            require_once($selectMigration['path']);
            /**
             * @var $migrate \Illuminate\Database\Migrations\Migration
             */
            $migrate = new $selectMigration['class'];
            try {
                $migration->delete();
                $migrate->down();
                CLI::success($migration['class'] . " was rollback!");

            } catch (\Exception $e) {
                CLI::error($migration['class'] . " was'nt rollback!");
                CLI::error("Error: " . $e->getMessage());
                break;
            }
        }
        if ($count == 0){
            CLI::success('Nothing rollback!');
        }
    }

    static function toArray($migrations)
    {
        $arMigration = [];
        foreach ($migrations['migration'] as $migration) {
            preg_match_all('/([a-z]+)+/', $migration, $matches);
            $class = [];
            foreach ($matches[1] as $match) {
                if ($match == 'php') {
                    continue;
                }
                $class[] = ucfirst($match);
            }
            $arMigration[] = [
                'class' => implode('', $class),
                'path' => $migrations['path'] . '/' . $migration
            ];
        }
        return $arMigration;
    }
}
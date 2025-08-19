<?php

namespace App\Console\Commands;

use App\Http\Services\GoogleSheetsService;
use Illuminate\Console\Command;
use function Laravel\Prompts\progress;

class GetGoogleCommentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-google-comments {--count=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Выводит комментарии из гугл таблицы (id | комментарий)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = (new GoogleSheetsService())->readSheet();

        $result = [];
        $count = $this->option('count') ?? -1;

        if ($this->output->isVerbose()) {
            foreach ($data as $row) {
                if ($count === 0) break;

                if (isset($row[7])) {
                    $result[] = $row[0] . ' | ' . $row[7] . PHP_EOL;
                    $count -= 1;
                }
            }
        } else {
            progress(
                label: 'Получение комментариев',
                steps: $data,
                callback: function (array $row) use (&$result, &$count) {
                    if (isset($row[7]) && $count !== 0) {
                        $result[] = $row[0] . ' | ' . $row[7] . PHP_EOL;
                        $count -= 1;
                    }
                }
            );
        }

        foreach ($result as $item) {
            echo $item;
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Converser;
use App\Actors\SaluteActor;
use Illuminate\Console\Command;
use App\Services\FacebookService;

class SaluteConversers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conversers:salute {--c|converser=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a salutation to actors';

    /**
     * Facebook Service
     * 
     * @var FacebookService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(FacebookService $service)
    {
        $this->service = $service;

        $conversers = $this->option('converser') ? 
                      Converser::whereIn('id', [$this->option('converser')]): 
                      Converser::query();

        $conversers = $conversers->get();

        $conversers->map([$this, "salute"]);

        return 0;
    }

    public function salute($converser)
    {
        $actor = new SaluteActor($converser, "");

        $this->service->sendMessage($actor);
    }
}

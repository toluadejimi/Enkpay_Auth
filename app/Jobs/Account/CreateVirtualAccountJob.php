<?php

namespace App\Jobs\Account;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Actions\Account\CreateVirtualAccount;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CreateVirtualAccountJob implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    protected User $user;

    /** Create a new job instance. */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /** Execute the job. */
    public function handle(): void
    {
        //try until created
        CreateVirtualAccount::execute($this->user);
    }
}

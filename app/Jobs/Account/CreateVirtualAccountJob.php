<?php

namespace App\Jobs\Account;

use Exception;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use App\Actions\Account\CreateVirtualAccount;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Controllers\Api\Account\UpdateUserAccountWithVirtualResponse;

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
        dd($user);
        $this->user = $user;
    }

    /**
     * @throws Exception
     * @throws RequestException
     */
    public function handle(): void
    {
        $response = retry(3, function () {
            return CreateVirtualAccount::execute($this->user);
        }, 5000);

        UpdateUserAccountWithVirtualResponse::execute($this->user, $response);
    }
}

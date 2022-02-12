<?php

namespace App\Jobs\Account;

use Exception;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\RequestException;
use App\Actions\Account\CreateVirtualAccount;
use App\Actions\UpdateUserAccountWithVirtualResponse;

class CreateVirtualAccountJob
{
    use Dispatchable;
    use SerializesModels;

    protected User $user;

    /** Create a new job instance. */
    public function __construct(User $user)
    {
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

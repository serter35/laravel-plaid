<?php

namespace Abivia\Plaid\Api;

use Illuminate\Support\Carbon;
use Abivia\Plaid\PlaidRequestException;

class Transactions extends AbstractResource
{
    /**
     * Get all transactions for a particular Account.
     *
     * @param string $accessToken
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param array<string,mixed> $options
     * @return Transactions
     * @throws PlaidRequestException
     */
    public function list(
        string $accessToken,
        Carbon $startDate,
        Carbon $endDate,
        array $options = []
    ): self
    {
        $this->sendRequest(
            'transactions/get',
            [
                'access_token' => $accessToken,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'options' => (object)$options
            ]
        );

        return $this;
    }

    /**
     * Refresh transactions for a particular Account.
     *
     * @param string $accessToken
     * @return Transactions
     * @throws PlaidRequestException
     */
    public function refresh(string $accessToken): self
    {
        $this->sendRequest('transactions/refresh', ['access_token' => $accessToken]);

        return $this;
    }

    /**
     * Sync transactions for a particular Account.
     *
     * @param string $accessToken
     * @param string $cursor
     * @param int $count
     * @param array $options
     * @return $this
     * @throws PlaidRequestException
     */
    public function sync(string $accessToken, string $cursor = 'now', int $count = 100, array $options = []): self
    {
        $this->sendRequest(
            'transactions/sync',
            [
                'access_token' => $accessToken,
                'cursor' => $cursor,
                'count' => min($count, 500),
                'options' => (object) $options
            ]
        );

        return $this;
    }
}

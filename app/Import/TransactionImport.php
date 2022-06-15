<?php

namespace App\Import;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use League\Csv\Reader;

class TransactionImport
{
    /**
     * @var Collection|Transaction
     */
    protected Transaction|Collection $transactions;

    /**
     * TransactionImport constructor.
     */
    public function __construct()
    {
        $this->transactions = new Collection();
    }

    /**
     * @param $path
     * @throws FileNotFoundException
     */
    public function parseFromCSV($path)
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException();
        }

        foreach (Reader::createFromPath($path) as $key => $csvLine) {
            $this->add(new Transaction([
                'transaction_id' => $key + 1,
                'operation_date' => Carbon::parse($csvLine[0]),
                'user_identification' => $csvLine[1],
                'user_type' => $csvLine[2],
                'operation_type' => $csvLine[3],
                'operation_amount' => $csvLine[4],
                'operation_currency' => $csvLine[5],
                'week_number_year' => strftime('%G-%V', strtotime($csvLine[0]))
            ]));
        }
    }

    /**
     * @return Collection|Transaction
     */
    public function getTransactions(): Collection|Transaction
    {
        return $this->transactions;
    }

    /**
     * @param Transaction $transaction
     *
     * @return $this
     */
    public function add(Transaction $transaction): static
    {
        $this->transactions->push($transaction);

        return $this;
    }
}

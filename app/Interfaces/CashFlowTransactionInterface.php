<?php

namespace App\Interfaces;

interface CashFlowTransactionInterface extends BaseInterface
{
    public function meaning($param);
    public function countIncome($date_start=null, $date_end=null);
    public function countOutcome($date_start=null, $date_end=null);
}

<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 20/04/2016
 * Time: 12:53
 */

namespace App\Classes;

use \XeroPrivate;

class Xero {

    public function invoiceStats($from, $to) {

        $from = $from->subDays(1);
        $to = $to->addDays(1);

        $invoices = XeroPrivate::load('Accounting\\Invoice')
            ->where('SentToContact', "true")
            //->where('Type', \XeroPHP\Models\Accounting\Invoice::INVOICE_TYPE_ACCREC)
            ->where(sprintf('Date > DateTime(%d, %02d, %02d)', $from->format('Y'), $from->format('m'), $from->format('d')))
            ->where(sprintf('Date < DateTime(%d, %02d, %02d)', $to->format('Y'), $to->format('m'), $to->format('d')))
            ->execute();

        $total = 0;
        foreach( $invoices as $invoice ) {
            $total += $invoice->getTotal();
        }

        $average = $invoices->count() ? ($total / $invoices->count()) : 0;

        return [
            'avg'   => $average,
            'total' => $total,
            'count' => $invoices->count()
        ];
    }

    public function expenseStats($from, $to) {

        $from = $from->subDays(1);
        $to = $to->addDays(1);

        $expenses = XeroPrivate::load('Accounting\\BankTransaction')
            ->where('Type', \XeroPHP\Models\Accounting\BankTransaction::TYPE_SPEND)
            ->where(sprintf('Date > DateTime(%d, %02d, %02d)', $from->format('Y'), $from->format('m'), $from->format('d')))
            ->where(sprintf('Date < DateTime(%d, %02d, %02d)', $to->format('Y'), $to->format('m'), $to->format('d')))
            ->execute();

        $total = 0;
        foreach( $expenses as $expense ) {
            $total += $expense->getTotal();
        }

        return $total;
    }
}